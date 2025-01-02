<?php
/**
 * Plugin Name: Marie Bridal App
 * Description: Hệ thống quản lý cho thuê váy cưới
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: mb-app
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MB_APP_VERSION', '1.0.0');
define('MB_APP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MB_APP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoload classes
require_once MB_APP_PLUGIN_DIR . 'vendor/autoload.php';

// Initialize plugin
class MB_App {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Initialize components
        add_action('plugins_loaded', [$this, 'init_plugin']);
        
        // Activation hooks
        register_activation_hook(__FILE__, function() {
            // Create database tables
            MB_App\Database\DB_Manager::create_tables();
            
            // Create roles and capabilities
            MB_App\Core\Roles::create_roles();
            
            // Create default notification settings for existing users
            $users = get_users(['fields' => 'ID']);
            foreach ($users as $user_id) {
                $settings = new MB_App\Models\Notification_Setting();
                $settings->user_id = $user_id;
                $settings->preferences = MB_App\Models\Notification_Setting::get_default_preferences();
                $settings->email_enabled = true;
                $settings->push_enabled = true;
                
                $notifications_repo = new MB_App\Database\Repositories\Notifications_Repository();
                $notifications_repo->update_settings($settings);
            }
            
            // Flush rewrite rules
            flush_rewrite_rules();
        });
        register_deactivation_hook(__FILE__, function() {
            // Remove roles
            MB_App\Core\Roles::remove_roles();
            
            // Flush rewrite rules
            flush_rewrite_rules();
        });

        // Check PHP version
        if (version_compare(PHP_VERSION, '7.4', '<')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . 
                    __('MB App requires PHP 7.4 or higher.', 'mb-app') . 
                    '</p></div>';
            });
            return;
        }

        // Check WordPress version
        if (version_compare($GLOBALS['wp_version'], '5.6', '<')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . 
                    __('MB App requires WordPress 5.6 or higher.', 'mb-app') . 
                    '</p></div>';
            });
            return;
        }
    }

    public function init_plugin() {
        // Initialize database
        new MB_App\Database\DB_Manager();
        
        // Initialize roles
        new MB_App\Core\Roles();
        
        // Initialize REST API
        add_action('rest_api_init', function() {
            new MB_App\API\API_Manager();
        });
    }

    public function activate() {
        // Create custom roles
        MB_App\Core\Roles::create_roles();
        
        // Create database tables
        MB_App\Database\DB_Manager::create_tables();
        
        flush_rewrite_rules();
    }

    public function deactivate() {
        // Remove custom roles
        MB_App\Core\Roles::remove_roles();
        
        flush_rewrite_rules();
    }
}

// Initialize plugin
MB_App::get_instance(); 