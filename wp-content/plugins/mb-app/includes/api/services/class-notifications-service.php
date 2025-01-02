<?php
namespace MB_App\Services;

use MB_App\Models\Notification;
use MB_App\Models\Notification_Setting;
use MB_App\Database\Repositories\Notifications_Repository;

class Notifications_Service {
    private $repository;

    public function __construct() {
        $this->repository = new Notifications_Repository();
    }

    public function create_notification(array $data): Notification {
        $notification = new Notification();
        $notification->user_id = absint($data['user_id']);
        $notification->type = sanitize_text_field($data['type']);
        $notification->title = sanitize_text_field($data['title']);
        $notification->content = wp_kses_post($data['content']);
        $notification->data = $data['data'] ?? null;
        $notification->is_read = false;

        // Check user notification preferences
        $settings = $this->repository->get_user_settings($notification->user_id);
        if ($settings && $this->should_notify($settings, $notification->type)) {
            $id = $this->repository->create($notification);
            
            // Send push notification if enabled
            if ($settings->push_enabled && $settings->fcm_token) {
                $this->send_push_notification($notification, $settings->fcm_token);
            }

            // Send email if enabled
            if ($settings->email_enabled) {
                $this->send_email_notification($notification);
            }
        }

        return $notification;
    }

    public function mark_as_read(int $notification_id): bool {
        return $this->repository->mark_as_read($notification_id, get_current_user_id());
    }

    public function update_settings(array $data): Notification_Setting {
        $setting = new Notification_Setting();
        $setting->user_id = get_current_user_id();
        $setting->preferences = $data['preferences'] ?? Notification_Setting::get_default_preferences();
        $setting->email_enabled = (bool) ($data['email_enabled'] ?? true);
        $setting->push_enabled = (bool) ($data['push_enabled'] ?? true);
        $setting->fcm_token = sanitize_text_field($data['fcm_token'] ?? '');

        $this->repository->update_settings($setting);
        return $setting;
    }

    private function should_notify(Notification_Setting $settings, string $type): bool {
        return isset($settings->preferences[$type]) && 
            ($settings->preferences[$type]['email'] || $settings->preferences[$type]['push']);
    }

    private function send_push_notification(Notification $notification, string $fcm_token): void {
        // Implement FCM push notification logic here
    }

    private function send_email_notification(Notification $notification): void {
        // Implement email notification logic here
        $user = get_user_by('ID', $notification->user_id);
        if ($user) {
            wp_mail(
                $user->user_email,
                $notification->title,
                $notification->content,
                [
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>'
                ]
            );
        }
    }
} 