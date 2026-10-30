<?php

namespace App\Http\Controllers\Dashboard\Moderator;

use App\Http\Controllers\Controller;
use App\Models\System\UserReport;
use App\Notifications\WarningNotification;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = UserReport::with(['reporter', 'subject']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(15)->withQueryString();

        return view('dashboard.moderator.reports.index', compact('reports'));
    }

    public function warn(Request $request, int $id)
    {
        $report = UserReport::findOrFail($id);
        $subject = $report->subject;

        $subject->notify(new WarningNotification($request->input('message', 'You have received a warning.')));

        $report->update(['status' => 'actioned']);

        return redirect()->back()->with('success', 'Warning sent and report marked as actioned.');
    }

    public function resolve(int $id)
    {
        $report = UserReport::findOrFail($id);
        $report->update(['status' => 'resolved']);

        return redirect()->back()->with('success', 'Report resolved.');
    }
}
