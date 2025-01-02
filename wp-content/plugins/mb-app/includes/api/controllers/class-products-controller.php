<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Products_Service;

class Products_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'products';
        $this->service = new Products_Service();
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

        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)/availability', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'check_availability'],
                'permission_callback' => [$this, 'get_item_permissions_check'],
                'args' => [
                    'start_date' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'date'
                    ],
                    'end_date' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'date'
                    ]
                ],
            ]
        ]);
    }

    public function get_items_permissions_check($request) {
        return current_user_can('mb_view_products');
    }

    public function get_items($request) {
        $items = $this->service->get_products($request->get_params());
        return rest_ensure_response($items);
    }

    public function check_availability($request) {
        $product_id = (int) $request['id'];
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $is_available = $this->service->check_availability($product_id, $start_date, $end_date);
        
        return rest_ensure_response([
            'is_available' => $is_available
        ]);
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
            'category' => [
                'description' => __('Filter products by category.', 'mb-app'),
                'type' => 'string',
                'enum' => array_keys(Product::get_categories()),
            ],
            'status' => [
                'description' => __('Filter products by status.', 'mb-app'),
                'type' => 'string',
                'enum' => array_keys(Product::get_statuses()),
            ],
        ];
    }
} 