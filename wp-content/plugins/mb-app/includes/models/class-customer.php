<?php
namespace MB_App\Models;

class Customer {
    public int $id;
    public string $name;
    public string $phone;
    public ?string $email;
    public string $source;
    public int $assigned_to;
    public string $status;
    public ?string $last_interaction;
    public ?string $next_follow_up;
    public int $created_by;
    public int $updated_by;
    public string $created_at;
    public string $updated_at;

    public static function get_sources(): array {
        return [
            'website' => __('Website', 'mb-app'),
            'facebook' => __('Facebook', 'mb-app'),
            'referral' => __('Giới thiệu', 'mb-app'),
            'walk_in' => __('Khách tới cửa hàng', 'mb-app')
        ];
    }

    public static function get_statuses(): array {
        return [
            'new' => __('Mới', 'mb-app'),
            'contacted' => __('Đã liên hệ', 'mb-app'),
            'qualified' => __('Tiềm năng', 'mb-app'),
            'converted' => __('Đã chốt', 'mb-app'),
            'lost' => __('Mất khách', 'mb-app')
        ];
    }
} 