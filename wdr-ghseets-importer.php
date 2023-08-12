<?php
/*
Plugin Name: WlozDoRyzu - importer Google Sheers
Description: Wtyczka umozliwia pobranie danych z arkusza google i udostępnienia ich uzytkownikowi w formie wyszukiwarki.
Author: Jakub Klimek
*/

use WdrGsheetsImporter\Admin\AdminController;
use WdrGsheetsImporter\Database\Database;
use WdrGsheetsImporter\Plugin;

require __DIR__ . '/vendor/autoload.php';

define('WDR_GSHEETS_PLUGIN', __DIR__);

$plugin = new Plugin(
    new AdminController(new Database())
);

register_activation_hook(__FILE__, [$plugin, 'activate']);
register_deactivation_hook(__FILE__, [$plugin, 'deactivate']);

add_action('admin_menu', [$plugin, 'addSidebarMenuItem']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    add_action('init', function () use ($plugin) { $plugin->adminController->handle(); });
    return;
}

