<?php
namespace MB_App\Models;

class Notification {
    public int $id;
    public int $user_id;
    public string $type;
    public string $title;
    public string $content;
    public ?array $data;
    public bool $is_read;
    public string $created_at;
    public ?string $read_at;

    public static function get_types(): array {
        return [
            'appointment' => __('Lịch hẹn', 'mb-app'),
            'task' => __('Công việc', 'mb-app'),
            'contract' => __('Hợp đồng', 'mb-app'),
            'customer' => __('Khách hàng', 'mb-app'),
            'system' => __('Hệ thống', 'mb-app')
        ];
    }

    public static function get_templates(): array {
        return [
            'appointment_created' => [
                'title' => __('Lịch hẹn mới', 'mb-app'),
                'content' => __('Bạn có lịch hẹn mới với khách hàng {customer_name} vào lúc {time} ngày {date}', 'mb-app')
            ],
            'task_assigned' => [
                'title' => __('Công việc mới', 'mb-app'),
                'content' => __('Bạn được giao công việc mới: {task_title}', 'mb-app')
            ],
            'contract_status_changed' => [
                'title' => __('Cập nhật hợp đồng', 'mb-app'),
                'content' => __('Hợp đồng {contract_code} đã được cập nhật trạng thái thành {status}', 'mb-app')
            ]
        ];
    }
} 