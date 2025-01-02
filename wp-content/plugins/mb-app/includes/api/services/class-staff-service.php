<?php
namespace MB_App\Services;

use MB_App\Models\Staff_Attendance;
use MB_App\Models\Staff_Task;
use MB_App\Database\Repositories\Staff_Repository;

class Staff_Service {
    private $repository;

    public function __construct() {
        $this->repository = new Staff_Repository();
    }

    public function check_in(array $data): Staff_Attendance {
        // Validate working hours and location if needed
        $this->validate_check_in($data);

        $attendance = new Staff_Attendance();
        $attendance->user_id = get_current_user_id();
        $attendance->check_in = current_time('mysql');
        $attendance->type = $this->determine_attendance_type($attendance->check_in);
        $attendance->note = sanitize_textarea_field($data['note'] ?? '');
        $attendance->location = sanitize_text_field($data['location'] ?? '');
        $attendance->ip_address = $_SERVER['REMOTE_ADDR'];

        $id = $this->repository->record_attendance($attendance);
        return $attendance;
    }

    public function check_out(int $attendance_id): bool {
        return $this->repository->update_checkout(
            $attendance_id,
            current_time('mysql')
        );
    }

    public function create_task(array $data): Staff_Task {
        $task = new Staff_Task();
        $task->title = sanitize_text_field($data['title']);
        $task->description = sanitize_textarea_field($data['description']);
        $task->status = 'pending';
        $task->priority = sanitize_text_field($data['priority']);
        $task->assigned_to = absint($data['assigned_to']);
        $task->assigned_by = get_current_user_id();
        $task->due_date = sanitize_text_field($data['due_date']);
        $task->created_by = get_current_user_id();

        $id = $this->repository->create_task($task);
        
        // Notify assigned user
        do_action('mb_task_assigned', $task);

        return $task;
    }

    private function validate_check_in(array $data): void {
        // Add validation logic here
        // For example: check if user already checked in today
        // Check if check-in time is within allowed window
        // Verify location or WiFi if required
    }

    private function determine_attendance_type(string $check_in): string {
        // Add logic to determine attendance type based on time
        // For example: normal, late, etc.
        return 'normal';
    }
} 