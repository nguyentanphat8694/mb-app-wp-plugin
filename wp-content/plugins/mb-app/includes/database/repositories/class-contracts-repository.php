<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Contract;
use MB_App\Models\Contract_Note;

class Contracts_Repository {
    private $wpdb;
    private $table_name;
    private $notes_table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'mb_contracts';
        $this->notes_table = $wpdb->prefix . 'mb_contract_notes';
    }

    public function create(Contract $contract): int {
        $result = $this->wpdb->insert(
            $this->table_name,
            [
                'code' => $contract->code,
                'type' => $contract->type,
                'customer_id' => $contract->customer_id,
                'product_id' => $contract->product_id,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'deposit' => $contract->deposit,
                'total' => $contract->total,
                'status' => $contract->status,
                'note' => $contract->note,
                'created_by' => $contract->created_by,
                'updated_by' => $contract->updated_by
            ],
            ['%s', '%s', '%d', '%d', '%s', '%s', '%f', '%f', '%s', '%s', '%d', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function add_note(Contract_Note $note): int {
        $result = $this->wpdb->insert(
            $this->notes_table,
            [
                'contract_id' => $note->contract_id,
                'content' => $note->content,
                'type' => $note->type,
                'priority' => $note->priority,
                'department' => $note->department,
                'is_internal' => $note->is_internal,
                'created_by' => $note->created_by
            ],
            ['%d', '%s', '%s', '%s', '%s', '%d', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function update_status(int $contract_id, string $status, int $updated_by): bool {
        $result = $this->wpdb->update(
            $this->table_name,
            [
                'status' => $status,
                'updated_by' => $updated_by
            ],
            ['id' => $contract_id],
            ['%s', '%d'],
            ['%d']
        );

        return $result !== false;
    }

    public function get_notes(int $contract_id): array {
        return $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->notes_table} WHERE contract_id = %d ORDER BY created_at DESC",
                $contract_id
            ),
            ARRAY_A
        );
    }

    public function check_conflicts(int $product_id, string $start_date, string $end_date, ?int $exclude_contract_id = null): array {
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->table_name} 
            WHERE product_id = %d 
            AND status IN ('approved', 'pending') 
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
        );

        if ($exclude_contract_id) {
            $query .= $this->wpdb->prepare(" AND id != %d", $exclude_contract_id);
        }

        return $this->wpdb->get_results($query, ARRAY_A);
    }
} 