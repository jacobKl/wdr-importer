<?php
/*
Plugin Name: WlozDoRyzu - importer Google Sheets
Description: Wtyczka umozliwia pobranie danych z arkusza google i udostępnienia ich uzytkownikowi w formie wyszukiwarki.
Author: Jakub Klimek
*/

use WdrGsheetsImporter\Admin\AdminController;
use WdrGsheetsImporter\Client\ClientController;
use WdrGsheetsImporter\Database\Database;
use WdrGsheetsImporter\Plugin;

require __DIR__ . '/vendor/autoload.php';

define('WDR_GSHEETS_PLUGIN', __DIR__);

$plugin = new Plugin(
    new AdminController(new Database())
);

$client = new ClientController(new Database());

add_action('wp_ajax_nopriv_get_makes', \Closure::fromCallable([$client, 'getMakes']));
add_action('wp_ajax_nopriv_get_models', \Closure::fromCallable([$client, 'getModels']));
add_action('wp_ajax_nopriv_get_services', \Closure::fromCallable([$client, 'getServices']));
add_action('wp_ajax_nopriv_get_categories', \Closure::fromCallable([$client, 'getCategories']));
register_activation_hook(__FILE__, \Closure::fromCallable([$plugin, 'activate']));
register_deactivation_hook(__FILE__, \Closure::fromCallable([$plugin, 'deactivate']));