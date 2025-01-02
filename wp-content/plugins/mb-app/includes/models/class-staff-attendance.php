<?php
namespace MB_App\Models;

class Staff_Attendance {
    public int $id;
    public int $user_id;
    public string $check_in;
    public ?string $check_out;
    public string $type;
    public ?string $note;
    public ?string $location;
    public ?string $ip_address;
    public string $created_at;

    public static function get_types(): array {
        return [
            'normal' => __('Bình thường', 'mb-app'),
            'late' => __('Đi muộn', 'mb-app'),
            'early_leave' => __('Về sớm', 'mb-app'),
            'overtime' => __('Tăng ca', 'mb-app'),
            'remote' => __('Làm từ xa', 'mb-app')
        ];
    }

    public static function get_status(string $check_in, ?string $check_out): string {
        if (empty($check_out)) {
            return 'working';
        }
        return 'completed';
    }
} 