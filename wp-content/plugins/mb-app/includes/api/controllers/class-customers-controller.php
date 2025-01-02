<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Customers_Service;

class Customers_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'customers';
        $this->service = new Customers_Service();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'permission_callback' => [$this, 'get_items_permissions_check'],
                'args' => $this->get_collection_params(),
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(true),
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_item'],
                'permission_callback' => [$this, 'get_item_permissions_check'],
                'args' => [
                    'id' => [
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        }
                    ],
                ],
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_item'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(false),
            ]
        ]);
    }

    public function get_items_permissions_check($request) {
        return current_user_can('mb_view_customers');
    }

    public function get_items($request) {
        $items = $this->service->get_customers($request->get_params());
        return rest_ensure_response($items);
    }

    public function create_item_permissions_check($request) {
        return current_user_can('mb_manage_customers');
    }

    public function create_item($request) {
        $customer = $this->service->create_customer($request->get_params());
        return rest_ensure_response($customer);
    }

    protected function get_collection_params() {
        return [
            'page' => [
                'description' => __('Current page of the collection.', 'mb-app'),
                'type' => 'integer',
                'default' => 1,
                'minimum' => 1,
                'sanitize_callback' => 'absint',
            ],
            'per_page' => [
                'description' => __('Maximum number of items to be returned in result set.', 'mb-app'),
                'type' => 'integer',
                'default' => 10,
                'minimum' => 1,
                'maximum' => 100,
                'sanitize_callback' => 'absint',
            ],
            'search' => [
                'description' => __('Limit results to those matching a string.', 'mb-app'),
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
        ];
    }
} 