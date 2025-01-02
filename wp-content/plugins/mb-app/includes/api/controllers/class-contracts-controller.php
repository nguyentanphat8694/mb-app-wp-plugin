<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Contracts_Service;

class Contracts_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'contracts';
        $this->service = new Contracts_Service();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(true),
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)/notes', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'add_note'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => [
                    'content' => [
                        'required' => true,
                        'type' => 'string'
                    ],
                    'type' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Contract_Note::get_types())
                    ],
                    'priority' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Contract_Note::get_priorities())
                    ],
                    'department' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Contract_Note::get_departments())
                    ],
                    'is_internal' => [
                        'type' => 'boolean',
                        'default' => false
                    ]
                ]
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)/status', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_status'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => [
                    'status' => [
                        'required' => true,
                        'type' => 'string',
                        'enum' => array_keys(Contract::get_statuses())
                    ]
                ]
            ]
        ]);
    }

    public function create_item_permissions_check($request) {
        return current_user_can('mb_create_contracts');
    }

    public function create_item($request) {
        try {
            $contract = $this->service->create_contract($request->get_params());
            return rest_ensure_response($contract);
        } catch (\Exception $e) {
            return new WP_Error(
                'contract_creation_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }

    public function add_note($request) {
        try {
            $note = $this->service->add_note(
                (int) $request['id'],
                $request->get_params()
            );
            return rest_ensure_response($note);
        } catch (\Exception $e) {
            return new WP_Error(
                'note_creation_failed',
                $e->getMessage(),
                ['status' => 400]
            );
        }
    }
} 