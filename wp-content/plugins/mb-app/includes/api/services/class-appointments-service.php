<?php
namespace MB_App\Services;

use MB_App\Models\Appointment;
use MB_App\Models\Schedule;
use MB_App\Database\Repositories\Appointments_Repository;

class Appointments_Service {
    private $repository;

    public function __construct() {
        $this->repository = new Appointments_Repository();
    }

    public function create_appointment(array $data): Appointment {
        // Validate available slot
        $available_slots = $this->repository->get_available_slots(
            $data['date'],
            $data['type']
        );

        if (!isset($available_slots[$data['time']]) || 
            !in_array($data['assigned_to'], $available_slots[$data['time']])) {
            throw new \Exception(__('Khung giờ này không khả dụng', 'mb-app'));
        }

        $appointment = new Appointment();
        $appointment->customer_id = absint($data['customer_id']);
        $appointment->type = sanitize_text_field($data['type']);
        $appointment->date = sanitize_text_field($data['date']);
        $appointment->time = sanitize_text_field($data['time']);
        $appointment->status = 'pending';
        $appointment->note = sanitize_textarea_field($data['note'] ?? '');
        $appointment->assigned_to = absint($data['assigned_to']);
        $appointment->services = array_map('sanitize_text_field', $data['services'] ?? []);
        $appointment->created_by = get_current_user_id();
        $appointment->updated_by = get_current_user_id();

        // Before creating appointment
        do_action('mb_before_create_appointment', $data);

        $id = $this->repository->create_appointment($appointment);

        // Send notifications
        do_action('mb_appointment_created', $appointment);

        // After creating appointment
        do_action('mb_after_create_appointment', $appointment);

        return $appointment;
    }

    public function update_schedule(array $data): Schedule {
        $schedule = new Schedule();
        $schedule->user_id = get_current_user_id();
        $schedule->date = sanitize_text_field($data['date']);
        $schedule->status = sanitize_text_field($data['status']);
        $schedule->time_slots = array_map('sanitize_text_field', $data['time_slots'] ?? []);
        $schedule->note = sanitize_textarea_field($data['note'] ?? '');
        $schedule->created_by = get_current_user_id();

        $this->repository->update_schedule($schedule);
        return $schedule;
    }

    public function get_available_slots(string $date, string $type): array {
        return $this->repository->get_available_slots($date, $type);
    }
} 