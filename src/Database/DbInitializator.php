<?php

namespace WdrGsheetsImporter\Database;

class DbInitializator
{
    public const SETTINGS_TABLE = 'wdr_gsheets_importer_settings';

    public static function initDb(): void
    {
        global $table_prefix;

        if ( ! function_exists( 'maybe_create_table' ) ) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        maybe_create_table($table_prefix . self::SETTINGS_TABLE, 'CREATE TABLE ' . $table_prefix . self::SETTINGS_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, sheet varchar(255), conf_file varchar(255), cron varchar(255))');
        
        $table = $table_prefix . self::SETTINGS_TABLE;
        $sql = "INSERT INTO $table VALUES(NULL, '', '', '')";
        dbDelta($sql);
    }

    public static function deleteDb(): void 
    {
        
    }
}
