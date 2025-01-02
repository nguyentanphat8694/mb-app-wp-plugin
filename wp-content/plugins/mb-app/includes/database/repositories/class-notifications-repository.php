<?php
namespace MB_App\Database\Repositories;

use MB_App\Models\Notification;
use MB_App\Models\Notification_Setting;

class Notifications_Repository {
    private $wpdb;
    private $notifications_table;
    private $settings_table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->notifications_table = $wpdb->prefix . 'mb_notifications';
        $this->settings_table = $wpdb->prefix . 'mb_notification_settings';
    }

    public function create(Notification $notification): int {
        $result = $this->wpdb->insert(
            $this->notifications_table,
            [
                'user_id' => $notification->user_id,
                'type' => $notification->type,
                'title' => $notification->title,
                'content' => $notification->content,
                'data' => json_encode($notification->data),
                'is_read' => $notification->is_read
            ],
            ['%d', '%s', '%s', '%s', '%s', '%d']
        );

        if ($result === false) {
            throw new \Exception($this->wpdb->last_error);
        }

        return $this->wpdb->insert_id;
    }

    public function mark_as_read(int $notification_id, int $user_id): bool {
        return $this->wpdb->update(
            $this->notifications_table,
            [
                'is_read' => true,
                'read_at' => current_time('mysql')
            ],
            [
                'id' => $notification_id,
                'user_id' => $user_id
            ],
            ['%d', '%s'],
            ['%d', '%d']
        ) !== false;
    }

    public function get_user_notifications(int $user_id, array $params = []): array {
        $query = "SELECT * FROM {$this->notifications_table} WHERE user_id = %d";
        $query_params = [$user_id];

        if (isset($params['is_read'])) {
            $query .= " AND is_read = %d";
            $query_params[] = $params['is_read'];
        }

        if (!empty($params['type'])) {
            $query .= " AND type = %s";
            $query_params[] = $params['type'];
        }

        $query .= " ORDER BY created_at DESC";

        if (!empty($params['per_page'])) {
            $query .= " LIMIT %d OFFSET %d";
            $query_params[] = $params['per_page'];
            $query_params[] = ($params['page'] - 1) * $params['per_page'];
        }

        return $this->wpdb->get_results(
            $this->wpdb->prepare($query, $query_params),
            ARRAY_A
        );
    }

    public function get_user_settings(int $user_id): ?Notification_Setting {
        $row = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->settings_table} WHERE user_id = %d",
                $user_id
            ),
            ARRAY_A
        );

        if (!$row) {
            return null;
        }

        $setting = new Notification_Setting();
        $setting->user_id = $row['user_id'];
        $setting->preferences = json_decode($row['preferences'], true);
        $setting->email_enabled = (bool) $row['email_enabled'];
        $setting->push_enabled = (bool) $row['push_enabled'];
        $setting->fcm_token = $row['fcm_token'];
        $setting->updated_at = $row['updated_at'];

        return $setting;
    }

    public function update_settings(Notification_Setting $setting): bool {
        return $this->wpdb->replace(
            $this->settings_table,
            [
                'user_id' => $setting->user_id,
                'preferences' => json_encode($setting->preferences),
                'email_enabled' => $setting->email_enabled,
                'push_enabled' => $setting->push_enabled,
                'fcm_token' => $setting->fcm_token
            ],
            ['%d', '%s', '%d', '%d', '%s']
        ) !== false;
    }
} 