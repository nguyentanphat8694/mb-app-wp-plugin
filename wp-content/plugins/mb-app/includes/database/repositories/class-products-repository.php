<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Product;

class Products_Repository {
    private $wpdb;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'mb_products';
    }

    public function create(Product $product): int {
        $result = $this->wpdb->insert(
            $this->table_name,
            [
                'code' => $product->code,
                'name' => $product->name,
                'category' => $product->category,
                'status' => $product->status,
                'description' => $product->description,
                'images' => json_encode($product->images),
                'purchase_date' => $product->purchase_date,
                'purchase_price' => $product->purchase_price,
                'current_condition' => $product->current_condition,
                'created_by' => $product->created_by,
                'updated_by' => $product->updated_by
            ],
            ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%s', '%d', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function find(int $id): ?Product {
        $row = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                $id
            ),
            ARRAY_A
        );

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function get_available_products(array $params = []): array {
        $query = "SELECT * FROM {$this->table_name} WHERE status = 'available'";
        
        if (!empty($params['category'])) {
            $query .= $this->wpdb->prepare(" AND category = %s", $params['category']);
        }

        if (!empty($params['search'])) {
            $search = '%' . $this->wpdb->esc_like($params['search']) . '%';
            $query .= $this->wpdb->prepare(
                " AND (name LIKE %s OR code LIKE %s)",
                $search,
                $search
            );
        }

        $rows = $this->wpdb->get_results($query, ARRAY_A);
        return array_map([$this, 'hydrate'], $rows);
    }

    public function check_availability(int $product_id, string $start_date, string $end_date): bool {
        $bookings_table = $this->wpdb->prefix . 'mb_product_bookings';
        
        $count = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT COUNT(*) FROM {$bookings_table} 
            WHERE product_id = %d 
            AND ((start_date BETWEEN %s AND %s) 
            OR (end_date BETWEEN %s AND %s)
            OR (start_date <= %s AND end_date >= %s))",
            $product_id,
            $start_date,
            $end_date,
            $start_date,
            $end_date,
            $start_date,
            $end_date
        ));

        return $count == 0;
    }

    private function hydrate(array $row): Product {
        $product = new Product();
        foreach ($row as $key => $value) {
            if (property_exists($product, $key)) {
                if ($key === 'images') {
                    $product->$key = json_decode($value, true);
                } else {
                    $product->$key = $value;
                }
            }
        }
        return $product;
    }
} 