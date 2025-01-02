<?php
namespace MB_App\Core;

class Roles {
    private static $roles = [
        'mb_admin' => [
            'name' => 'MB Admin',
            'capabilities' => [
                'mb_manage_all' => true,
                'mb_manage_staff' => true,
                'mb_manage_customers' => true,
                'mb_manage_products' => true,
                'mb_manage_contracts' => true,
                'mb_manage_appointments' => true,
                'mb_manage_schedule' => true,
                'mb_view_reports' => true
            ]
        ],
        'mb_manager' => [
            'name' => 'MB Manager',
            'capabilities' => [
                'mb_manage_staff' => true,
                'mb_manage_customers' => true,
                'mb_manage_contracts' => true,
                'mb_view_reports' => true
            ]
        ],
        'mb_photographer' => [
            'name' => 'MB Photographer',
            'capabilities' => [
                'mb_manage_appointments' => true,
                'mb_view_customers' => true
            ]
        ],
        'mb_sales' => [
            'name' => 'MB Sales',
            'capabilities' => [
                'mb_manage_customers' => true,
                'mb_create_contracts' => true,
                'mb_view_products' => true
            ]
        ],
        // Add other roles as needed
    ];

    public static function create_roles() {
        foreach (self::$roles as $role_slug => $role_data) {
            add_role($role_slug, $role_data['name'], $role_data['capabilities']);
        }
    }

    public static function remove_roles() {
        foreach (self::$roles as $role_slug => $role_data) {
            remove_role($role_slug);
        }
    }
} 