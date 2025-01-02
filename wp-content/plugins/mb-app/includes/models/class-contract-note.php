<?php
namespace MB_App\Models;

class Contract_Note {
    public int $id;
    public int $contract_id;
    public string $content;
    public string $type;
    public string $priority;
    public string $department;
    public bool $is_internal;
    public int $created_by;
    public string $created_at;

    public static function get_types(): array {
        return [
            'customer_request' => __('Yêu cầu khách hàng', 'mb-app'),
            'internal_note' => __('Ghi chú nội bộ', 'mb-app'),
            'modification' => __('Thay đổi hợp đồng', 'mb-app')
        ];
    }

    public static function get_priorities(): array {
        return [
            'low' => __('Thấp', 'mb-app'),
            'medium' => __('Trung bình', 'mb-app'),
            'high' => __('Cao', 'mb-app')
        ];
    }

    public static function get_departments(): array {
        return [
            'sales' => __('Kinh doanh', 'mb-app'),
            'accounting' => __('Kế toán', 'mb-app'),
            'tailor' => __('May đo', 'mb-app'),
            'photo' => __('Nhiếp ảnh', 'mb-app')
        ];
    }
} 