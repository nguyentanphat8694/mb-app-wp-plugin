<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Staff_Attendance;
use MB_App\Models\Staff_Task;

class Staff_Repository {
    private $wpdb;
    private $attendance_table;
    private $tasks_table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->attendance_table = $wpdb->prefix . 'mb_staff_attendance';
        $this->tasks_table = $wpdb->prefix . 'mb_staff_tasks';
    }

    public function record_attendance(Staff_Attendance $attendance): int {
        $result = $this->wpdb->insert(
            $this->attendance_table,
            [
                'user_id' => $attendance->user_id,
                'check_in' => $attendance->check_in,
                'type' => $attendance->type,
                'note' => $attendance->note,
                'location' => $attendance->location,
                'ip_address' => $attendance->ip_address
            ],
            ['%d', '%s', '%s', '%s', '%s', '%s']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function update_checkout(int $attendance_id, string $check_out): bool {
        return $this->wpdb->update(
            $this->attendance_table,
            ['check_out' => $check_out],
            ['id' => $attendance_id],
            ['%s'],
            ['%d']
        ) !== false;
    }

    public function create_task(Staff_Task $task): int {
        $result = $this->wpdb->insert(
            $this->tasks_table,
            [
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'assigned_to' => $task->assigned_to,
                'assigned_by' => $task->assigned_by,
                'due_date' => $task->due_date,
                'created_by' => $task->created_by
            ],
            ['%s', '%s', '%s', '%s', '%d', '%d', '%s', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function get_monthly_attendance(int $user_id, string $year_month): array {
        return $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->attendance_table} 
                WHERE user_id = %d 
                AND DATE_FORMAT(check_in, '%%Y-%%m') = %s 
                ORDER BY check_in DESC",
                $user_id,
                $year_month
            ),
            ARRAY_A
        );
    }

    public function get_user_tasks(int $user_id, array $params = []): array {
        $query = "SELECT * FROM {$this->tasks_table} WHERE assigned_to = %d";
        $query_params = [$user_id];

        if (!empty($params['status'])) {
            $query .= " AND status = %s";
            $query_params[] = $params['status'];
        }

        if (!empty($params['priority'])) {
            $query .= " AND priority = %s";
            $query_params[] = $params['priority'];
        }

        $query .= " ORDER BY due_date ASC";

        return $this->wpdb->get_results(
            $this->wpdb->prepare($query, $query_params),
            ARRAY_A
        );
    }
} 