<?php

namespace App\Services;

use App\Contracts\IDashboardService;
use App\Models\Babysitting\Booking;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Blog\BlogPost;
use App\Models\Marketplace\Order;
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
use Illuminate\Support\Facades\DB;
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
                    ->concat(ModerationLog::with('moderator')->orderByDesc('created_at')->take(5)->get()->map(fn($log) => [
                        'type' => 'Moderation',
                        'action' => ucfirst($log->action) . ' on ' . class_basename($log->target_type) . ' #' . $log->target_id,
                        'user_name' => $log->moderator?->name ?? 'Unknown',
                        'timestamp' => $log->submitted_at ?? $log->created_at,
                    ]))
                    ->concat(RoleAssignmentLog::with('admin')->orderByDesc('created_at')->take(5)->get()->map(fn($log) => [
                        'type' => 'Role Assignment',
                        'action' => 'Changed role to ' . $log->new_role,
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
            $shopId = $shop?->id;

            // Performance Optimization:
            // Fetch product IDs owned by this shop once into memory to eliminate redundant correlated
            // double-EXISTS subqueries (`whereHas('items.product')`) across multiple dashboard metric queries.
            // This simplifies the SQL query structure from subqueries to direct `whereIn` conditions.
            $productIds = $shopId ? Product::where('shop_id', $shopId)->pluck('id') : collect();
            $hasProducts = $productIds->isNotEmpty();

            return [
                'shop' => $shop,
                'total_products' => $productIds->count(),
                'total_orders' => $hasProducts
                    ? Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->count()
                    : 0,
                'pending_orders' => $hasProducts
                    ? Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
                        ->where('status', 'pending')
                        ->count()
                    : 0,
                'total_revenue' => $hasProducts
                    ? (float) Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
                        ->where('status', 'delivered')
                        ->sum('total')
                    : 0,
                'avg_rating' => $hasProducts
                    ? (float) (ProductReview::whereIn('product_id', $productIds)->avg('rating') ?? 0)
                    : 0,
                'total_reviews' => $hasProducts
                    ? ProductReview::whereIn('product_id', $productIds)->count()
                    : 0,
                'recent_orders' => $hasProducts
                    ? Order::with('parent', 'items.product')
                        ->whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
                        ->orderByDesc('created_at')
                        ->take(5)
                        ->get()
                    : collect(),
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
