<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Babysitting\Booking;
use App\Models\Marketplace\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.reports.index');
    }

    public function usersPerWeek()
    {
        $data = User::selectRaw('YEARWEEK(created_at, 1) as week, COUNT(*) as total')
            ->where('created_at', '>=', now()->subWeeks(12))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        return response()->json($data);
    }

    public function bookingsPerDay()
    {
        $data = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    public function topProducts()
    {
        $data = OrderItem::selectRaw('product_id, SUM(qty) as total_qty')
            ->whereHas('order', fn ($q) => $q->where('status', 'delivered'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(10)
            ->with('product')
            ->get();

        return response()->json($data);
    }

    public function cityUsage()
    {
        $data = User::selectRaw('city, COUNT(*) as total')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('total')
            ->get();

        return response()->json($data);
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'users');
        $headers = [['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="'.$type.'.csv"']];

        $callback = function () use ($type) {
            $handle = fopen('php://output', 'w');

            if ($type === 'bookings') {
                fputcsv($handle, ['ID', 'Parent', 'Babysitter', 'Date', 'Status', 'Total Fee']);
                Booking::with(['parent', 'babysitter'])->chunk(100, function ($bookings) use ($handle) {
                    foreach ($bookings as $b) {
                        fputcsv($handle, [$b->id, $b->parent?->name, $b->babysitter?->name, $b->date, $b->status->value ?? '', $b->total_fee]);
                    }
                });
            } else {
                fputcsv($handle, ['ID', 'Name', 'Email', 'City', 'Status', 'Created At']);
                User::chunk(100, function ($users) use ($handle) {
                    foreach ($users as $u) {
                        fputcsv($handle, [$u->id, $u->name, $u->email, $u->city, $u->status->value ?? '', $u->created_at]);
                    }
                });
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers[0]);
    }
}
