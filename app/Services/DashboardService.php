<?php

namespace App\Services;

use App\Contracts\IDashboardService;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Blog\BlogPost;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\ProductReview;
use App\Models\Marketplace\Shop;
use App\Models\Profiles\BabysitterProfile;
use App\Models\Support\SupportTicket;
use App\Models\System\FlaggedItem;
use App\Models\System\ModerationLog;
use App\Models\System\RoleAssignmentLog;
use App\Models\System\UserReport;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardService implements IDashboardService
{
    public function getAdminOverview(): array
    {
        return Cache::remember('dashboard.admin_overview', 60, function () {
            $totalUsers = User::count();
            $totalBookings = Booking::count();
            $totalShops = Shop::count();
            $pendingReviews = ProductReview::where('status', 'pending')->count();
            $monthlyRevenue = Order::where('status', 'delivered')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total');
            $openTickets = SupportTicket::whereIn('status', ['new', 'open'])->count();

            return [
                'overview' => [
                    'total_users' => $totalUsers,
                    'total_bookings' => $totalBookings,
                    'active_listings' => $totalShops,
                    'pending_reviews' => $pendingReviews,
                    'monthly_revenue' => $monthlyRevenue,
                    'open_tickets' => $openTickets,
                ],
                'recentActivity' => collect()
                    ->concat(ModerationLog::with('moderator')->orderByDesc('created_at')->take(5)->get()->map(fn ($log) => [
                        'type' => 'Moderation',
                        'action' => ucfirst($log->action).' on '.class_basename($log->target_type).' #'.$log->target_id,
                        'user_name' => $log->moderator?->name ?? 'Unknown',
                        'timestamp' => $log->submitted_at ?? $log->created_at,
                    ]))
                    ->concat(RoleAssignmentLog::with('admin')->orderByDesc('created_at')->take(5)->get()->map(fn ($log) => [
                        'type' => 'Role Assignment',
                        'action' => 'Changed role to '.$log->new_role,
                        'user_name' => $log->admin?->name ?? 'Unknown',
                        'timestamp' => $log->created_at,
                    ]))
                    ->sortByDesc('timestamp')
                    ->take(5)
                    ->values(),
                'dbHealthy' => true,
            ];
        });
    }

    public function getModeratorOverview(): array
    {
        return Cache::remember('dashboard.moderator_overview', 60, function () {
            return [
                'pending_reviews' => BabysitterProfile::where('verified_status', 'pending')->count(),
                'pending_blog_posts' => BlogPost::where('status', 'under_review')->count(),
                'pending_products' => Product::where('status', 'under_review')->count(),
                'flagged_items' => FlaggedItem::with('reporter', 'flaggable')
                    ->where('status', 'pending')
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get(),
                'user_reports' => UserReport::with('reporter', 'subject')
                    ->where('status', 'pending')
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get(),
            ];
        });
    }

    public function getBabysitterOverview(string $userId): array
    {
        return Cache::remember("dashboard.babysitter.{$userId}", 60, function () use ($userId) {
            return [
                'total_bookings' => Booking::where('babysitter_id', $userId)->count(),
                'completed_bookings' => Booking::where('babysitter_id', $userId)->where('status', 'completed')->count(),
                'pending_bookings' => Booking::where('babysitter_id', $userId)->where('status', 'pending')->count(),
                'average_rating' => BabysitterReview::where('babysitter_id', $userId)->avg('rating'),
                'total_earned' => Booking::where('babysitter_id', $userId)
                    ->where('status', 'completed')
                    ->sum('total_fee'),
                'recent_bookings' => Booking::with('parent', 'bookingChildren.child')
                    ->where('babysitter_id', $userId)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
                'recent_reviews' => BabysitterReview::with('parent')
                    ->where('babysitter_id', $userId)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
            ];
        });
    }

    public function getParentOverview(string $userId): array
    {
        return Cache::remember("dashboard.parent.{$userId}", 60, function () use ($userId) {
            return [
                'total_bookings' => Booking::where('parent_id', $userId)->count(),
                'active_bookings' => Booking::where('parent_id', $userId)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->count(),
                'total_orders' => Order::where('parent_id', $userId)->count(),
                'recent_bookings' => Booking::with('babysitter', 'bookingChildren.child')
                    ->where('parent_id', $userId)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
                'recent_orders' => Order::with('items.product')
                    ->where('parent_id', $userId)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
            ];
        });
    }

    public function getShopOwnerOverview(string $userId): array
    {
        return Cache::remember("dashboard.shop_owner.{$userId}", 60, function () use ($userId) {
            $shop = Shop::where('user_id', $userId)->first();
            if (! $shop) {
                return [
                    'shop' => null,
                    'total_products' => 0,
                    'total_orders' => 0,
                    'pending_orders' => 0,
                    'total_revenue' => 0,
                    'avg_rating' => 0,
                    'total_reviews' => 0,
                    'recent_orders' => collect(),
                ];
            }

            $shopId = $shop->id;

            // Bolt Optimization: Retrieve product IDs once to avoid redundant multi-table EXISTS subqueries across multiple order and review metrics.
            $productIds = Product::where('shop_id', $shopId)->pluck('id');

            if ($productIds->isEmpty()) {
                return [
                    'shop' => $shop,
                    'total_products' => 0,
                    'total_orders' => 0,
                    'pending_orders' => 0,
                    'total_revenue' => 0,
                    'avg_rating' => 0,
                    'total_reviews' => 0,
                    'recent_orders' => collect(),
                ];
            }

            // Subquery select for order IDs belonging to these products
            $shopOrderIds = OrderItem::whereIn('product_id', $productIds)->select('order_id');

            return [
                'shop' => $shop,
                'total_products' => $productIds->count(),
                'total_orders' => Order::whereIn('id', $shopOrderIds)->count(),
                'pending_orders' => Order::whereIn('id', $shopOrderIds)
                    ->where('status', 'pending')
                    ->count(),
                'total_revenue' => (float) Order::whereIn('id', $shopOrderIds)
                    ->where('status', 'delivered')
                    ->sum('total'),
                'avg_rating' => (float) (ProductReview::whereIn('product_id', $productIds)->avg('rating') ?? 0),
                'total_reviews' => ProductReview::whereIn('product_id', $productIds)->count(),
                'recent_orders' => Order::with('parent', 'items.product')
                    ->whereIn('id', $shopOrderIds)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
            ];
        });
    }

    public function getDoctorOverview(string $userId): array
    {
        return Cache::remember("dashboard.doctor.{$userId}", 60, function () use ($userId) {
            return [
                'total_posts' => BlogPost::where('doctor_id', $userId)->count(),
                'published_posts' => BlogPost::where('doctor_id', $userId)->where('status', 'published')->count(),
                'total_views' => BlogPost::where('doctor_id', $userId)->sum('views'),
                'recent_posts' => BlogPost::where('doctor_id', $userId)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get(),
            ];
        });
    }

    public function getSupportOverview(string $userId): array
    {
        return Cache::remember("dashboard.support.{$userId}", 60, function () use ($userId) {
            return [
                'assigned_tickets' => SupportTicket::where('assigned_to', $userId)
                    ->whereNotIn('status', ['resolved', 'closed'])
                    ->count(),
                'resolved_today' => SupportTicket::where('assigned_to', $userId)
                    ->where('status', 'resolved')
                    ->whereDate('updated_at', today())
                    ->count(),
                'recent_tickets' => SupportTicket::with('user')
                    ->where('assigned_to', $userId)
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get(),
            ];
        });
    }
}
