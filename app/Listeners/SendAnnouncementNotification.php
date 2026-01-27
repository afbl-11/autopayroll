<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Models\EmployeeDevice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendAnnouncementNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnnouncementCreated $event): void
    {
        // Get all FCM tokens of employees
        $tokens = EmployeeDevice::pluck('fcm_token')->toArray();

        if (empty($tokens)) return;

        // Create notification
        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                $event->announcement->title,
                $event->announcement->body
            ));

        // Send to multiple tokens
        app('firebase.messaging')->sendMulticast($message, $tokens);
    }
}
