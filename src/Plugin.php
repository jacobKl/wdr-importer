<?php 

namespace WdrGsheetsImporter;

use WdrGsheetsImporter\Admin\AdminController;
use WdrGsheetsImporter\Database\DbInitializator;

defined('ABSPATH') or die(404);

class Plugin {
    public AdminController $adminController;
    public ClientController $clientController;

    public function __construct(AdminController $adminController)
    {
        $this->adminController = $adminController;
    }

    public function activate() {
        DbInitializator::initDb();
    }

    public function deactivate() {

    }

    public function uninstall() {

    }

    public function addSidebarMenuItem() {
        add_menu_page('Synchronizacja arkusza google', 'WDR Importer', 'manage_options', 'wdr-gsheets-importer', [$this->adminController, 'settings']);
        
        add_submenu_page(
            'wdr-gsheets-importer',
            'Kategorie',
            'Kategorie',
            'manage_options',
            'categories',
            [$this->adminController, 'categories']
        );
    }
}
