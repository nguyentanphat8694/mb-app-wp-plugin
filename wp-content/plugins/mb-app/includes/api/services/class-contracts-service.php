<?php
namespace MB_App\Services;

use MB_App\Models\Contract;
use MB_App\Models\Contract_Note;
use MB_App\Database\Repositories\Contracts_Repository;
use MB_App\Database\Repositories\Products_Repository;

class Contracts_Service {
    private $repository;
    private $products_repository;

    public function __construct() {
        $this->repository = new Contracts_Repository();
        $this->products_repository = new Products_Repository();
    }

    public function create_contract(array $data): Contract {
        // Validate product availability
        $conflicts = $this->repository->check_conflicts(
            $data['product_id'],
            $data['start_date'],
            $data['end_date']
        );

        if (!empty($conflicts)) {
            throw new \Exception(__('Sản phẩm đã được đặt trong thời gian này', 'mb-app'));
        }

        // Generate contract code
        $data['code'] = $this->generate_contract_code($data['type']);

        // Create contract
        $contract = new Contract();
        $contract->code = $data['code'];
        $contract->type = sanitize_text_field($data['type']);
        $contract->customer_id = absint($data['customer_id']);
        $contract->product_id = absint($data['product_id']);
        $contract->start_date = sanitize_text_field($data['start_date']);
        $contract->end_date = sanitize_text_field($data['end_date']);
        $contract->deposit = floatval($data['deposit']);
        $contract->total = floatval($data['total']);
        $contract->status = 'draft';
        $contract->note = sanitize_textarea_field($data['note'] ?? '');
        $contract->created_by = get_current_user_id();
        $contract->updated_by = get_current_user_id();

        $id = $this->repository->create($contract);
        
        // Add initial note if provided
        if (!empty($data['initial_note'])) {
            $this->add_note($id, [
                'content' => $data['initial_note'],
                'type' => 'customer_request',
                'priority' => 'medium',
                'department' => 'sales',
                'is_internal' => false
            ]);
        }

        return $contract;
    }

    public function add_note(int $contract_id, array $data): Contract_Note {
        $note = new Contract_Note();
        $note->contract_id = $contract_id;
        $note->content = sanitize_textarea_field($data['content']);
        $note->type = sanitize_text_field($data['type']);
        $note->priority = sanitize_text_field($data['priority']);
        $note->department = sanitize_text_field($data['department']);
        $note->is_internal = (bool) $data['is_internal'];
        $note->created_by = get_current_user_id();

        $this->repository->add_note($note);
        return $note;
    }

    private function generate_contract_code(string $type): string {
        $prefix = strtoupper(substr($type, 0, 3));
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}{$date}{$random}";
    }
} 