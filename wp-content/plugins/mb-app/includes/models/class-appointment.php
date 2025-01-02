<?php
namespace MB_App\Models;

class Appointment {
    public int $id;
    public int $customer_id;
    public string $type;
    public string $date;
    public string $time;
    public string $status;
    public ?string $note;
    public int $assigned_to;
    public ?array $services;
    public int $created_by;
    public int $updated_by;
    public string $created_at;
    public string $updated_at;

    public static function get_types(): array {
        return [
            'consultation' => __('Tư vấn', 'mb-app'),
            'fitting' => __('Thử váy', 'mb-app'),
            'photo' => __('Chụp ảnh', 'mb-app'),
            'makeup_test' => __('Thử make-up', 'mb-app')
        ];
    }

    public static function get_statuses(): array {
        return [
            'pending' => __('Chờ xác nhận', 'mb-app'),
            'confirmed' => __('Đã xác nhận', 'mb-app'),
            'in_progress' => __('Đang diễn ra', 'mb-app'),
            'completed' => __('Hoàn thành', 'mb-app'),
            'cancelled' => __('Đã hủy', 'mb-app'),
            'no_show' => __('Khách không đến', 'mb-app')
        ];
    }

    public static function get_time_slots(): array {
        return [
            '09:00' => '09:00 AM',
            '10:00' => '10:00 AM',
            '11:00' => '11:00 AM',
            '13:30' => '01:30 PM',
            '14:30' => '02:30 PM',
            '15:30' => '03:30 PM',
            '16:30' => '04:30 PM'
        ];
    }
} 