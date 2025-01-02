<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Appointment;
use MB_App\Models\Schedule;

class Appointments_Repository {
    private $wpdb;
    private $appointments_table;
    private $schedules_table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->appointments_table = $wpdb->prefix . 'mb_appointments';
        $this->schedules_table = $wpdb->prefix . 'mb_schedules';
    }

    public function create_appointment(Appointment $appointment): int {
        $result = $this->wpdb->insert(
            $this->appointments_table,
            [
                'customer_id' => $appointment->customer_id,
                'type' => $appointment->type,
                'date' => $appointment->date,
                'time' => $appointment->time,
                'status' => $appointment->status,
                'note' => $appointment->note,
                'assigned_to' => $appointment->assigned_to,
                'services' => json_encode($appointment->services),
                'created_by' => $appointment->created_by,
                'updated_by' => $appointment->updated_by
            ],
            ['%d', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function update_schedule(Schedule $schedule): bool {
        $result = $this->wpdb->replace(
            $this->schedules_table,
            [
                'user_id' => $schedule->user_id,
                'date' => $schedule->date,
                'status' => $schedule->status,
                'time_slots' => json_encode($schedule->time_slots),
                'note' => $schedule->note,
                'created_by' => $schedule->created_by
            ],
            ['%d', '%s', '%s', '%s', '%s', '%d']
        );

        return $result !== false;
    }

    public function get_available_slots(string $date, string $type): array {
        // Get all staff members who can handle this type of appointment
        $staff_ids = $this->get_qualified_staff($type);
        
        // Get their schedules for the given date
        $schedules = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->schedules_table} 
                WHERE date = %s AND user_id IN (" . implode(',', $staff_ids) . ")
                AND status = 'available'",
                $date
            ),
            ARRAY_A
        );

        // Get existing appointments for the date
        $existing_appointments = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT time, assigned_to FROM {$this->appointments_table} 
                WHERE date = %s AND status IN ('pending', 'confirmed', 'in_progress')",
                $date
            ),
            ARRAY_A
        );

        return $this->calculate_available_slots($schedules, $existing_appointments);
    }

    private function get_qualified_staff(string $type): array {
        // Implementation depends on your staff qualification system
        // This is a simplified version
        return [1, 2, 3]; // Example staff IDs
    }

    private function calculate_available_slots(array $schedules, array $existing_appointments): array {
        $available_slots = [];
        $all_time_slots = Appointment::get_time_slots();

        foreach ($schedules as $schedule) {
            $staff_slots = json_decode($schedule['time_slots'], true);
            foreach ($staff_slots as $time) {
                if (isset($all_time_slots[$time])) {
                    // Check if slot is already booked
                    $is_available = true;
                    foreach ($existing_appointments as $appointment) {
                        if ($appointment['time'] === $time && 
                            $appointment['assigned_to'] === $schedule['user_id']) {
                            $is_available = false;
                            break;
                        }
                    }
                    if ($is_available) {
                        $available_slots[$time][] = $schedule['user_id'];
                    }
                }
            }
        }

        return $available_slots;
    }
} 