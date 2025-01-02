<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Appointments_Service;

class Appointments_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'appointments';
        $this->service = new Appointments_Service();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
                'args' => [
                    'customer_id' => [
                        'required' => true,
                        'type' => 'integer',
                        'sanitize_callback' => 'absint'
                    ],
                    'type' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Appointment::get_types()),
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    'date' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'date'
                    ],
                    'time' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Appointment::get_time_slots())
                    ],
                    'assigned_to' => [
                        'required' => true,
                        'type' => 'integer'
                    ]
                ]
            ]
        ]);

        register_rest_route($this->namespace, '/schedules', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'update_schedule'],
                'permission_callback' => [$this, 'update_schedule_permissions_check'],
                'args' => [
                    'date' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'date'
                    ],
                    'status' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Schedule::get_statuses())
                    ],
                    'time_slots' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'string',
                            'enum' => array_keys(Appointment::get_time_slots())
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function create_item_permissions_check($request) {
        return current_user_can('mb_manage_appointments');
    }

    public function update_schedule_permissions_check($request) {
        return current_user_can('mb_manage_schedule');
    }

    public function create_item($request) {
        try {
            $appointment = $this->service->create_appointment($request->get_params());
            return rest_ensure_response($appointment);
        } catch (\Exception $e) {
            return new WP_Error(
                'appointment_creation_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }

    public function update_schedule($request) {
        try {
            $schedule = $this->service->update_schedule($request->get_params());
            return rest_ensure_response($schedule);
        } catch (\Exception $e) {
            return new WP_Error(
                'schedule_update_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }
} 