<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Models\System\Notification;

class NotificationsController
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('dashboard.babysitter.notifications.index', compact('notifications'));
    }
}
