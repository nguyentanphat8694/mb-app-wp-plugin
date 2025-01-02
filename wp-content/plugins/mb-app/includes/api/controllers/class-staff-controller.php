<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Staff_Service;

class Staff_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'staff';
        $this->service = new Staff_Service();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/staff/attendance', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'check_in'],
                'permission_callback' => [$this, 'attendance_permissions_check'],
                'args' => [
                    'location' => [
                        'type' => 'string'
                    ],
                    'note' => [
                        'type' => 'string'
                    ]
                ]
            ]
        ]);

        register_rest_route($this->namespace, '/staff/attendance/(?P<id>[\d]+)/checkout', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'check_out'],
                'permission_callback' => [$this, 'attendance_permissions_check']
            ]
        ]);

        register_rest_route($this->namespace, '/staff/tasks', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_task'],
                'permission_callback' => [$this, 'task_create_permissions_check'],
                'args' => [
                    'title' => [
                        'required' => true,
                        'type' => 'string'
                    ],
                    'description' => [
                        'required' => true,
                        'type' => 'string'
                    ],
                    'priority' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Staff_Task::get_priorities())
                    ],
                    'assigned_to' => [
                        'required' => true,
                        'type' => 'integer'
                    ],
                    'due_date' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'date'
                    ]
                ]
            ]
        ]);
    }

    public function attendance_permissions_check($request) {
        return current_user_can('mb_manage_attendance');
    }

    public function task_create_permissions_check($request) {
        return current_user_can('mb_manage_tasks');
    }

    public function check_in($request) {
        try {
            $attendance = $this->service->check_in($request->get_params());
            return rest_ensure_response($attendance);
        } catch (\Exception $e) {
            return new WP_Error(
                'check_in_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }

    public function check_out($request) {
        try {
            $success = $this->service->check_out((int) $request['id']);
            return rest_ensure_response(['success' => $success]);
        } catch (\Exception $e) {
            return new WP_Error(
                'check_out_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }

    public function create_task($request) {
        try {
            $task = $this->service->create_task($request->get_params());
            return rest_ensure_response($task);
        } catch (\Exception $e) {
            return new WP_Error(
                'task_creation_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }
} 