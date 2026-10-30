<?php

namespace App\Http\Controllers\Dashboard\Moderator;

use App\Contracts\IModerationService;
use App\Contracts\INotificationService;
use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\System\FlaggedItem;
use App\Models\User;

class FlaggedController extends Controller
{
    public function __construct(
        private IModerationService $moderationService,
        private INotificationService $notificationService,
    ) {}

    public function index()
    {
        $items = $this->moderationService->getFlagged();

        return view('dashboard.moderator.flagged.index', compact('items'));
    }

    public function dismiss(int $id)
    {
        $this->moderationService->dismissFlag($id);

        return redirect()->back()->with('success', 'Flag dismissed.');
    }

    public function unpublish(int $id)
    {
        $flagged = FlaggedItem::with('flaggable')->findOrFail($id);

        if ($flagged->flaggable) {
            $flagged->flaggable->update(['status' => ContentStatus::Archived]);
        }

        $flagged->update(['status' => 'resolved']);

        return redirect()->back()->with('success', 'Flagged content unpublished.');
    }

    public function escalate(int $id)
    {
        $this->moderationService->escalateFlag($id);

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $this->notificationService->send(
                $admin->id,
                'flag_escalated',
                'A flagged item has been escalated for admin review.',
                route('admin.moderation.index'),
            );
        }

        return redirect()->back()->with('success', 'Flag escalated to admin.');
    }

    public function warn(int $id)
    {
        $flagged = FlaggedItem::with('flaggable')->findOrFail($id);
        $owner = User::find($flagged->flaggable?->doctor_id ?? $flagged->flaggable?->shop_id);

        if ($owner) {
            $this->notificationService->send(
                $owner->id,
                'moderation_warning',
                'Your content has been flagged and may be removed if violations continue.',
                route('dashboard'),
            );
        }

        $flagged->update(['status' => 'warned']);

        return redirect()->back()->with('success', 'Warning sent to content owner.');
    }
}
