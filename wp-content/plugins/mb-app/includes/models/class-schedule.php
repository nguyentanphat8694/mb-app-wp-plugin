<?php
namespace MB_App\Models;

class Schedule {
    public int $id;
    public int $user_id;
    public string $date;
    public string $status;
    public ?array $time_slots;
    public ?string $note;
    public int $created_by;
    public string $created_at;
    public string $updated_at;

    public static function get_statuses(): array {
        return [
            'available' => __('Có thể đặt lịch', 'mb-app'),
            'unavailable' => __('Không thể đặt lịch', 'mb-app'),
            'leave' => __('Nghỉ phép', 'mb-app')
        ];
    }
} 