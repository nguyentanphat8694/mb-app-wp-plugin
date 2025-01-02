<?php
namespace MB_App\API\Controllers;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use MB_App\Services\Notifications_Service;

class Notifications_Controller extends WP_REST_Controller {
    private $service;
    
    public function __construct() {
        $this->namespace = 'mb/v1';
        $this->rest_base = 'notifications';
        $this->service = new Notifications_Service();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'permission_callback' => [$this, 'get_items_permissions_check'],
                'args' => $this->get_collection_params()
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)/read', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'mark_as_read'],
                'permission_callback' => [$this, 'update_item_permissions_check']
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->rest_base . '/settings', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_settings'],
                'permission_callback' => [$this, 'get_items_permissions_check']
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_settings'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => [
                    'preferences' => [
                        'type' => 'object'
                    ],
                    'email_enabled' => [
                        'type' => 'boolean'
                    ],
                    'push_enabled' => [
                        'type' => 'boolean'
                    ],
                    'fcm_token' => [
                        'type' => 'string'
                    ]
                ]
            ]
        ]);
    }

    public function get_items_permissions_check($request) {
        return is_user_logged_in();
    }

    public function update_item_permissions_check($request) {
        return is_user_logged_in();
    }

    public function get_items($request) {
        $params = $request->get_params();
        $notifications = $this->service->get_user_notifications(get_current_user_id(), $params);
        return rest_ensure_response($notifications);
    }

    public function mark_as_read($request) {
        $success = $this->service->mark_as_read((int) $request['id']);
        return rest_ensure_response(['success' => $success]);
    }

    public function get_settings($request) {
        $settings = $this->service->get_user_settings(get_current_user_id());
        return rest_ensure_response($settings);
    }

    public function update_settings($request) {
        $settings = $this->service->update_settings($request->get_params());
        return rest_ensure_response($settings);
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
            'type' => [
                'description' => __('Filter notifications by type.', 'mb-app'),
                'type' => 'string',
                'enum' => array_keys(Notification::get_types()),
            ],
            'is_read' => [
                'description' => __('Filter notifications by read status.', 'mb-app'),
                'type' => 'boolean',
            ],
        ];
    }
} 