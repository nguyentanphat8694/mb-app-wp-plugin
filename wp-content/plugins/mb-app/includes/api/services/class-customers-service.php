<?php
namespace MB_App\Services;

use MB_App\Models\Customer;
use MB_App\Database\Repositories\Customers_Repository;

class Customers_Service {
    private $repository;

    public function __construct() {
        $this->repository = new Customers_Repository();
    }

    public function get_customers(array $params): array {
        // Implement pagination, filtering, and search logic here
        return [];
    }

    public function create_customer(array $data): Customer {
        $customer = new Customer();
        $customer->name = sanitize_text_field($data['name']);
        $customer->phone = sanitize_text_field($data['phone']);
        $customer->email = sanitize_email($data['email'] ?? '');
        $customer->source = sanitize_text_field($data['source']);
        $customer->assigned_to = absint($data['assigned_to']);
        $customer->status = 'new';
        $customer->created_by = get_current_user_id();
        $customer->updated_by = get_current_user_id();

        $id = $this->repository->create($customer);
        return $this->repository->find($id);
    }

    public function update_customer(int $id, array $data): Customer {
        $customer = $this->repository->find($id);
        if (!$customer) {
            throw new \Exception(__('Customer not found', 'mb-app'));
        }

        $customer->name = sanitize_text_field($data['name']);
        $customer->phone = sanitize_text_field($data['phone']);
        $customer->email = sanitize_email($data['email'] ?? '');
        $customer->source = sanitize_text_field($data['source']);
        $customer->assigned_to = absint($data['assigned_to']);
        $customer->status = sanitize_text_field($data['status']);
        $customer->updated_by = get_current_user_id();

        $this->repository->update($customer);
        return $customer;
    }
} 