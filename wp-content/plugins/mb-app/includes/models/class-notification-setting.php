<?php
namespace MB_App\Models;

class Notification_Setting {
    public int $user_id;
    public array $preferences;
    public bool $email_enabled;
    public bool $push_enabled;
    public ?string $fcm_token;
    public string $updated_at;

    public static function get_default_preferences(): array {
        return [
            'appointment' => [
                'email' => true,
                'push' => true
            ],
            'task' => [
                'email' => true,
                'push' => true
            ],
            'contract' => [
                'email' => true,
                'push' => true
            ],
            'customer' => [
                'email' => true,
                'push' => true
            ],
            'system' => [
                'email' => true,
                'push' => true
            ]
        ];
    }
} 