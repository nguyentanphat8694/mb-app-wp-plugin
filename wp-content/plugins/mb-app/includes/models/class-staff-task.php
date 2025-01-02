<?php
namespace MB_App\Models;

class Staff_Task {
    public int $id;
    public string $title;
    public string $description;
    public string $status;
    public string $priority;
    public int $assigned_to;
    public ?int $assigned_by;
    public string $due_date;
    public ?string $completed_at;
    public ?string $completion_note;
    public int $created_by;
    public string $created_at;
    public string $updated_at;

    public static function get_statuses(): array {
        return [
            'pending' => __('Chờ xử lý', 'mb-app'),
            'in_progress' => __('Đang thực hiện', 'mb-app'),
            'completed' => __('Hoàn thành', 'mb-app'),
            'cancelled' => __('Đã hủy', 'mb-app')
        ];
    }

    public static function get_priorities(): array {
        return [
            'low' => __('Thấp', 'mb-app'),
            'medium' => __('Trung bình', 'mb-app'),
            'high' => __('Cao', 'mb-app'),
            'urgent' => __('Khẩn cấp', 'mb-app')
        ];
    }
} 