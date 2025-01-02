<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Customer;

class Customers_Repository {
    private $wpdb;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'mb_customers';
    }

    public function create(Customer $customer): int {
        $result = $this->wpdb->insert(
            $this->table_name,
            [
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'source' => $customer->source,
                'assigned_to' => $customer->assigned_to,
                'status' => $customer->status,
                'created_by' => $customer->created_by,
                'updated_by' => $customer->updated_by
            ],
            ['%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function find(int $id): ?Customer {
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

    public function update(Customer $customer): bool {
        $result = $this->wpdb->update(
            $this->table_name,
            [
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'source' => $customer->source,
                'assigned_to' => $customer->assigned_to,
                'status' => $customer->status,
                'updated_by' => $customer->updated_by
            ],
            ['id' => $customer->id],
            ['%s', '%s', '%s', '%s', '%d', '%s', '%d'],
            ['%d']
        );

        return $result !== false;
    }

    private function hydrate(array $row): Customer {
        $customer = new Customer();
        foreach ($row as $key => $value) {
            if (property_exists($customer, $key)) {
                $customer->$key = $value;
            }
        }
        return $customer;
    }
} 