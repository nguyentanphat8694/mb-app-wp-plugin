<?php
namespace MB_App\Services;

use MB_App\Models\Product;
use MB_App\Database\Repositories\Products_Repository;

class Products_Service {
    private $repository;

    public function __construct() {
        $this->repository = new Products_Repository();
    }

    public function get_products(array $params): array {
        return $this->repository->get_available_products($params);
    }

    public function create_product(array $data): Product {
        $product = new Product();
        $product->code = sanitize_text_field($data['code']);
        $product->name = sanitize_text_field($data['name']);
        $product->category = sanitize_text_field($data['category']);
        $product->status = 'available';
        $product->description = sanitize_textarea_field($data['description'] ?? '');
        $product->images = $this->process_images($data['images'] ?? []);
        $product->purchase_date = sanitize_text_field($data['purchase_date'] ?? '');
        $product->purchase_price = floatval($data['purchase_price'] ?? 0);
        $product->current_condition = 'new';
        $product->created_by = get_current_user_id();
        $product->updated_by = get_current_user_id();

        $id = $this->repository->create($product);
        return $this->repository->find($id);
    }

    public function check_availability(int $product_id, string $start_date, string $end_date): bool {
        return $this->repository->check_availability($product_id, $start_date, $end_date);
    }

    private function process_images(array $images): array {
        // Handle image upload and processing
        // This is a placeholder - implement actual image processing logic
        return array_map(function($image) {
            return sanitize_text_field($image);
        }, $images);
    }
} 