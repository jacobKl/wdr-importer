<?php 

namespace WdrGsheetsImporter\Database;

use WdrGsheetsImporter\Database\DbInitializator;
use WdrGsheetsImporter\Database\Model\SettingsModel;

if ( ! function_exists( 'maybe_create_table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

class Database {

    public function __construct()
    {

    }

    public function updateSettings(string $sheet, string $confFile, string $cron): void 
    {
        global $wpdb, $table_prefix;

        $wpdb->query($wpdb->prepare('
            UPDATE ' . $table_prefix . DbInitializator::SETTINGS_TABLE . ' SET sheet = %s, conf_file = %s, cron = %s
        ', [
            'sheet' => $sheet,
            'conf_file' => $confFile,
            'cron' => $cron
        ]));
    }

    public function getSettings(): ?SettingsModel
    {
        global $wpdb, $table_prefix;
        
        $result = $wpdb->get_results('SELECT * FROM ' . $table_prefix . DbInitializator::SETTINGS_TABLE . ' WHERE id = 1', ARRAY_A);
    
        return SettingsModel::fromDb($result[0]);
    }
}