<?php

namespace App\Services;

use App\Models\EmployeeDevice;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService
{
    public function notifyEmployees(
        array $employeeIds,
        string $title,
        string $body,
        array $data = []
    ): void {
        $tokens = EmployeeDevice::whereIn('employee_id', $employeeIds)
            ->pluck('fcm_token')
            ->toArray();

        if (empty($tokens)) {
            return;
        }

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        app('firebase.messaging')->sendMulticast($message, $tokens);
    }
}
