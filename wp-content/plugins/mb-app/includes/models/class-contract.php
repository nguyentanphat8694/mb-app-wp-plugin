<?php
namespace MB_App\Models;

class Contract {
    public int $id;
    public string $code;
    public string $type;
    public int $customer_id;
    public int $product_id;
    public string $start_date;
    public string $end_date;
    public float $deposit;
    public float $total;
    public string $status;
    public ?string $note;
    public int $created_by;
    public int $updated_by;
    public string $created_at;
    public string $updated_at;

    public static function get_types(): array {
        return [
            'rental' => __('Thuê váy cưới', 'mb-app'),
            'pre_wedding' => __('Chụp ảnh trước cưới', 'mb-app'),
            'wedding' => __('Chụp ảnh ngày cưới', 'mb-app')
        ];
    }

    public static function get_statuses(): array {
        return [
            'draft' => __('Bản nháp', 'mb-app'),
            'pending' => __('Chờ duyệt', 'mb-app'),
            'approved' => __('Đã duyệt', 'mb-app'),
            'rejected' => __('Từ chối', 'mb-app'),
            'completed' => __('Hoàn thành', 'mb-app'),
            'cancelled' => __('Đã hủy', 'mb-app')
        ];
    }
} 