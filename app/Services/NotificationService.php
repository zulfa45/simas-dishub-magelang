<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create a notification and attach recipients.
     */
    public function createNotification(array $data, array $userIds, $createdBy)
    {
        return DB::transaction(function () use ($data, $userIds, $createdBy) {
            $data['created_by'] = $createdBy;
            $data['published_at'] = now();

            $notification = Notification::create($data);

            $recipients = array_map(function ($userId) use ($notification) {
                return [
                    'notification_id' => $notification->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $userIds);

            NotificationRecipient::insert($recipients);

            // Here we could also trigger a real-time event or push notification if needed
            // event(new NotificationCreated($notification, $userIds));

            return $notification;
        });
    }

    /**
     * Mark a notification as read for a specific user.
     */
    public function markAsRead($notificationId, $userId)
    {
        return NotificationRecipient::where('notification_id', $notificationId)
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}