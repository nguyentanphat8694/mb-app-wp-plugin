<?php
namespace MB_App\Models;

class Product {
    public int $id;
    public string $code;
    public string $name;
    public string $category;
    public string $status;
    public ?string $description;
    public ?array $images;
    public ?string $purchase_date;
    public ?float $purchase_price;
    public ?string $current_condition;
    public ?string $last_maintenance;
    public int $created_by;
    public int $updated_by;
    public string $created_at;
    public string $updated_at;

    public static function get_statuses(): array {
        return [
            'available' => __('Có sẵn', 'mb-app'),
            'rented' => __('Đang cho thuê', 'mb-app'),
            'maintenance' => __('Đang bảo trì', 'mb-app'),
            'retired' => __('Ngừng sử dụng', 'mb-app')
        ];
    }

    public static function get_categories(): array {
        return [
            'wedding_dress' => __('Váy cưới', 'mb-app'),
            'evening_dress' => __('Váy dạ hội', 'mb-app'),
            'accessories' => __('Phụ kiện', 'mb-app')
        ];
    }

    public static function get_conditions(): array {
        return [
            'new' => __('Mới', 'mb-app'),
            'good' => __('Tốt', 'mb-app'),
            'fair' => __('Trung bình', 'mb-app'),
            'poor' => __('Kém', 'mb-app')
        ];
    }
} 