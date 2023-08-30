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

        $this->initActions();
    }

    private function initActions(): void 
    {
        add_action( 'init', function () {
            if (!session_id()) {
                session_start();
            }
        });

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            add_action('init', \Closure::fromCallable([$this->adminController, 'handle']));
        }

        add_action('admin_menu', \Closure::fromCallable([$this, 'addSidebarMenuItem']));

        add_filter('theme_page_templates', \Closure::fromCallable([$this, 'addNewTemplate']));

        add_filter('template_include', \Closure::fromCallable([$this, 'injectTemplate']));
    }

    public function activate() {
        DbInitializator::initDb();
    }

    public function deactivate() {
        DbInitializator::deactivateDb();
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

    public function addNewTemplate(array $templates): array
    {
        $templates = array_merge($templates, ['wdr-template' => 'Cennik']);
        return $templates;
    }

    public function injectTemplate(string $template) {
		global $post;

        if ( ! $post ) {
			return $template;
		}

        $metadata = get_post_custom($post->post_id);

        if(!isset($metadata['_wp_page_template'])) {
            return $template;
        }

        $name = $metadata['_wp_page_template'][0];

        if ($name == 'wdr-template') {
            $file = constant('WDR_GSHEETS_PLUGIN') . '/templates/wdr-template.php';

            if (file_exists($file)) {
                return $file;
            }
        }

		return $template;
	}
}
