<?php
namespace MB_App\Database;

class DB_Manager {
    public static function create_tables() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $charset_collate = $wpdb->get_charset_collate();

        // Create contracts table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_contracts (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            code varchar(50) NOT NULL,
            type varchar(50) NOT NULL,
            customer_id bigint(20) NOT NULL,
            product_id bigint(20) NOT NULL,
            start_date date NOT NULL,
            end_date date NOT NULL,
            deposit decimal(10,2) NOT NULL,
            total decimal(10,2) NOT NULL,
            status varchar(50) NOT NULL,
            note text,
            created_by bigint(20) NOT NULL,
            updated_by bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY customer_id (customer_id),
            KEY product_id (product_id)
        ) $charset_collate;";
        dbDelta($sql);

        // Create products table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_products (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            code varchar(50) NOT NULL,
            name varchar(255) NOT NULL,
            category varchar(50) NOT NULL,
            status varchar(50) NOT NULL,
            description text,
            images longtext,
            purchase_date date,
            purchase_price decimal(10,2),
            current_condition varchar(50),
            last_maintenance datetime,
            created_by bigint(20) NOT NULL,
            updated_by bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);

        // Create customers table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_customers (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            phone varchar(20) NOT NULL,
            email varchar(100),
            source varchar(50),
            assigned_to bigint(20) NOT NULL,
            status varchar(50),
            last_interaction datetime,
            next_follow_up datetime,
            created_by bigint(20) NOT NULL,
            updated_by bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY assigned_to (assigned_to)
        ) $charset_collate;";
        dbDelta($sql);

        // Create notifications table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_notifications (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            type varchar(50) NOT NULL,
            title varchar(255) NOT NULL,
            content text NOT NULL,
            data longtext,
            is_read tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id)
        ) $charset_collate;";
        dbDelta($sql);

        // Create notification settings table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_notification_settings (
            user_id bigint(20) NOT NULL,
            preferences longtext NOT NULL,
            email_enabled tinyint(1) DEFAULT 1,
            push_enabled tinyint(1) DEFAULT 1,
            fcm_token varchar(255),
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (user_id)
        ) $charset_collate;";
        dbDelta($sql);

        // Create staff attendance table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_staff_attendance (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            check_in datetime NOT NULL,
            check_out datetime DEFAULT NULL,
            type varchar(50) NOT NULL,
            note text,
            location varchar(255),
            ip_address varchar(45),
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id)
        ) $charset_collate;";
        dbDelta($sql);

        // Create staff tasks table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}mb_staff_tasks (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text,
            status varchar(50) NOT NULL,
            priority varchar(50) NOT NULL,
            assigned_to bigint(20) NOT NULL,
            assigned_by bigint(20) NOT NULL,
            due_date date NOT NULL,
            created_by bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY assigned_to (assigned_to)
        ) $charset_collate;";
        dbDelta($sql);

        // Add other tables as defined in ERD
    }
} 