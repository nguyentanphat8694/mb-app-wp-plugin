<?php
// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Drop plugin tables
$tables = [
    'mb_contracts',
    'mb_contract_notes', 
    'mb_products',
    'mb_customers',
    'mb_appointments',
    'mb_schedules',
    'mb_notifications',
    'mb_notification_settings',
    'mb_staff_attendance',
    'mb_staff_tasks'
];

foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}{$table}");
}

// Delete plugin options
delete_option('mb_app_version');
delete_option('mb_app_settings'); 