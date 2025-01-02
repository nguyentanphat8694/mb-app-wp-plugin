<?php
namespace MB_App\Core;

class Logger {
    public static function log($message, $type = 'info') {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(sprintf('[MB App] [%s] %s', $type, $message));
        }
    }
} 