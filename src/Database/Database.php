<?php 

namespace WdrGsheetsImporter\Database;

use WdrGsheetsImporter\Database\DbInitializator;

use WdrGsheetsImporter\Database\Model\SettingsModel;
use WdrGsheetsImporter\Database\Model\CategoriesModel;

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

    public function getCategory(int $id): ?CategoriesModel
    {
        global $wpdb, $table_prefix;
        
        $result = $wpdb->get_results($wpdb->prepare(
                'SELECT * FROM ' . $table_prefix . DbInitializator::CATEGORIES_TABLE . ' WHERE id = %d',
                [
                    'id' => $id
                ]
            ),
            ARRAY_A
        );

        if ($result[0]) {
            return CategoriesModel::fromDb($result[0]);
        } else {
            return null;
        }

    }

    public function getCategories(): array 
    {
        global $wpdb, $table_prefix;

        $results = $wpdb->get_results('SELECT * FROM ' . $table_prefix . DbInitializator::CATEGORIES_TABLE, ARRAY_A) ?? [];
        
        $results = array_map(function (array $item) {
            return CategoriesModel::fromDb($item);
        }, $results);

        return $results;
    }

    public function createCategory(string $name, string $sheetColumns, string $filename): void 
    {
        global $wpdb, $table_prefix;
        
        $wpdb->query($wpdb->prepare('INSERT INTO ' . $table_prefix . DbInitializator::CATEGORIES_TABLE . ' VALUES(null, %s, %s, %s)', [
            $name,
            $sheetColumns,
            $filename
        ]));
    }

    public function updateCategory(CategoriesModel $category): void 
    {
        global $wpdb, $table_prefix;

        $wpdb->query($wpdb->prepare('UPDATE ' . $table_prefix . DbInitializator::CATEGORIES_TABLE . ' SET name = %s, sheet_columns = %s, image = %s WHERE id = %d', [
            'name' => $category->getName(),
            'sheet_columns' => $category->getSheetColumns(),
            'image' => $category->getImage(),
            'id' => $category->getId()
        ]));
    }

    public function createMake(int $id, string $name): void 
    {
        global $wpdb, $table_prefix;

        $wpdb->query($wpdb->prepare('INSERT INTO ' . $table_prefix . DbInitializator::MAKES_TABLE . ' VALUES(%d, %s)', [
            $id,
            $name
        ]));
    }

    public function createModel(int $id, string $name, int $makeId): void 
    {
        global $wpdb, $table_prefix;

        $wpdb->query($wpdb->prepare('INSERT INTO ' . $table_prefix . DbInitializator::MODELS_TABLE . ' VALUES(%d, %s, %d)', [
            $id,
            $name,
            $makeId
        ]));
    }

    public function createService(array $service): void 
    {
        global $wpdb, $table_prefix;

        $wpdb->query($wpdb->prepare('INSERT INTO ' . $table_prefix . DbInitializator::SERVICES_TABLE . ' VALUES(NULL, %d, %d, %s, %d)', [
            $service['make_id'],
            $service['model_id'],
            $service['column_name'],
            $service['price'],
        ]));
    }

    public function clearDb(): void 
    {
        global $wpdb, $table_prefix;

        $tables = [
            $table_prefix . DbInitializator::MAKES_TABLE,
            $table_prefix . DbInitializator::MODELS_TABLE,
            $table_prefix . DbInitializator::SERVICES_TABLE
        ];

        foreach ($tables as $table) {
            $wpdb->query("TRUNCATE TABLE $table");
        }
    }
}