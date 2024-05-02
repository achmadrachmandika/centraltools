<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function unread()
    {
        $unreadNotifications = Notification::where('status', 'unread')->count();
        return response()->json(['count' => $unreadNotifications]);
    }


    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->status = 'seen';
            $notification->save();
        }
        return response()->json(['message' => 'Notification marked as read']);
    }
}

