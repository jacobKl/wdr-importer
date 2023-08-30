<?php

namespace WdrGsheetsImporter\Database;

class DbInitializator
{
    public const SETTINGS_TABLE = 'wdr_importer_settings';
    public const CATEGORIES_TABLE = 'wdr_importer_categories';
    public const MAKES_TABLE = 'wdr_importer_makes';
    public const MODELS_TABLE = 'wdr_importer_models';
    public const SERVICES_TABLE = 'wdr_importer_services';

    public static function initDb(): void
    {
        global $table_prefix;

        if ( ! function_exists( 'maybe_create_table' ) ) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        /** SETTINGS */
        maybe_create_table($table_prefix . self::SETTINGS_TABLE, 'CREATE TABLE ' . $table_prefix . self::SETTINGS_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, sheet varchar(255), conf_file varchar(255), cron varchar(255))');
        $table = $table_prefix . self::SETTINGS_TABLE;
        $sql = "INSERT INTO $table VALUES(NULL, '', '', '')";
        dbDelta($sql);

        /** CATEGORIES */
        maybe_create_table($table_prefix . self::CATEGORIES_TABLE, 'CREATE TABLE ' . $table_prefix . self::CATEGORIES_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, name varchar(100), sheet_columns TEXT, sheet_columns_display_names TEXT, image TEXT)');

        /** MAKES */
        maybe_create_table($table_prefix . self::MAKES_TABLE,  'CREATE TABLE ' . $table_prefix . self::MAKES_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, name varchar(100))');
    
        /** MODELS */
        maybe_create_table($table_prefix . self::MODELS_TABLE,  'CREATE TABLE ' . $table_prefix . self::MODELS_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, name varchar(100), make_id int)');

        /** SERVICES */
        maybe_create_table($table_prefix . self::SERVICES_TABLE,  'CREATE TABLE ' . $table_prefix . self::SERVICES_TABLE . ' (id INT PRIMARY KEY AUTO_INCREMENT, make_id int, model_id int, column_name varchar(100), price varchar(200))');
    }

    public static function deactivateDb(): void 
    {
        global $wpdb, $table_prefix;
        $wpdb->query('DROP TABLE ' . $table_prefix . self::SERVICES_TABLE);
        $wpdb->query('DROP TABLE ' . $table_prefix . self::MAKES_TABLE);
        $wpdb->query('DROP TABLE ' . $table_prefix . self::MODELS_TABLE);
    }

    public static function deleteDb(): void 
    {
        
    }
}
