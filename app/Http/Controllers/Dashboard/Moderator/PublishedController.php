<?php

namespace App\Http\Controllers\Dashboard\Moderator;

use App\Contracts\IModerationService;
use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\System\ModerationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublishedController extends Controller
{
    public function __construct(private IModerationService $moderationService) {}

    public function index(Request $request)
    {
        $items = $this->moderationService->getPublished($request->get('type'));

        return view('dashboard.moderator.published.index', compact('items'));
    }

    public function unpublish(string $type, int $id)
    {
        $targetClass = 'App\\Models\\'.$type;
        $target = $targetClass::findOrFail($id);
        $target->update(['status' => ContentStatus::Archived]);

        ModerationLog::create([
            'moderator_id' => Auth::id(),
            'action' => 'unpublished',
            'target_type' => $targetClass,
            'target_id' => $target->id,
            'reason' => 'Unpublished by moderator',
            'submitted_at' => now(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Item unpublished successfully.');
    }
}
