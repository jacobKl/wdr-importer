<?php 

namespace WdrGsheetsImporter\Admin;

use WdrGsheetsImporter\Database\Database;
use WdrGsheetsImporter\Traits\TemplatingTrait;
use WdrGsheetsImporter\Admin\Synchronizer;

class AdminController {

    private const UPDATE_SETTINGS = 'update_settings';
    private const SYNCHRONIZE = 'synchronize';
    private const CREATE_CATEGORY = 'create_category';
    private const UPDATE_CATEGORY = 'edit_category';
    private const DELETE_CATEGORY = 'delete_category';

    private Database $database;

    use TemplatingTrait;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function handle()
    {
        $actionType = $_POST['action_type'];
        switch ($actionType) {
            case self::UPDATE_SETTINGS: 
                return $this->updateSettings();
            case self::SYNCHRONIZE: 
                return $this->synchronize();
            case self::CREATE_CATEGORY: 
                return $this->createCategory();
            case self::UPDATE_CATEGORY: 
                return $this->updateCategory();
            case self::DELETE_CATEGORY: 
                return $this->deleteCategory();
        }
    }

    public function settings(): void
    {
        $settings = $this->database->getSettings();
        $flash = '';    

        if (isset($_SESSION['WDR_FLASH'])) {
            $flash = $_SESSION['WDR_FLASH'];
            unset($_SESSION['WDR_FLASH']);
        }

        $view = $this->display('settings', [
            'sheet' => $settings->getSheet(),
            'conf_file' => 'credentials.json',
            'cron' => $settings->getCron(),
            'file_exists' => file_exists(constant('WDR_GSHEETS_PLUGIN') . '/credentials.json'),
            'flash' => $flash
        ]);

        echo $view;
    }

    private function updateSettings(): void 
    {
        $sheet = $_POST['sheet'];
        $cron = $_POST['cron'];

        $file = $_FILES['conf_file'];
        move_uploaded_file($file["tmp_name"], constant('WDR_GSHEETS_PLUGIN') . '/credentials.json');

        $this->database->updateSettings($sheet, constant('WDR_GSHEETS_PLUGIN') . '/credentials.json', $cron);
        $this->redirectToPage('wdr-gsheets-importer');
    }
    
    public function categories(): void 
    {
        $categories = $this->database->getCategories();

        echo $this->display('categories', [
            'categories' => $categories
        ]);
    }

    public function createCategory(): void 
    {
        $name = $_POST['name'];
        $sheetColumnsDisplayNames = $_POST['sheet_columns_display_names'];
        $sheetColumns = $_POST['sheet_columns'];
        $file = $_FILES['image'];

        $filename = '';

        if (!isset($name) || !isset($sheetColumnsDisplayNames) || !isset($sheetColumns) || !isset($file)) {
            return;
        }

        if (isset($_FILES['image'])) {
            $filename = $this->uploadToWordpressStorage($_FILES['image']);
        }

        $this->database->createCategory($name, $sheetColumnsDisplayNames, $sheetColumns, $filename);
        $this->redirectToPage('categories');
    }

    public function updateCategory(): void 
    {
        $id = (int)$_POST['category_id'];
        $filename = '';

        if (!$id) return;

        $category = $this->database->getCategory($id);

        if (!$category) return;


        if (isset($_FILES['image'])) {
            $filename = $this->uploadToWordpressStorage($_FILES['image']);
        }

        $category->update($_POST['name'], $_POST['sheet_columns_display_names'], $_POST['sheet_columns'], $filename);
        $this->database->updateCategory($category);
        $this->redirectToPage('categories');
    }

    public function deleteCategory(): void 
    {
        $id = (int)$_POST['category_id'];
        if (!$id) return;

        $this->database->deleteCategory($id);
        $this->redirectToPage('categories');
    }

    private function uploadToWordpressStorage(array $file): string 
    {
        $uploadDir = wp_upload_dir();
        $target = $uploadDir['path'] . '/wdr-gsheets-importer/';

        if (!file_exists($target)) {
            wp_mkdir_p($target);
        }

        $filename = $file['name'];
        $tempFile = $file['tmp_name'];

        if (move_uploaded_file($tempFile, $target . $filename)) {
            $attachment = array(
                'post_mime_type' => mime_content_type( $target . $filename ),
                'post_title' => preg_replace( '/\.[^.]+$/', '', $filename ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attachmentId = wp_insert_attachment($attachment, $target . $filename);

            if (!is_wp_error($attachmentId)) {
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $attachmentData = wp_generate_attachment_metadata( $attachmentId, $target . $filename );
                wp_update_attachment_metadata( $attachmentId, $attachmentData );
            }

            return wp_get_attachment_url($attachmentId);
        } else {
            return '';
        }

    }

    private function synchronize(): void 
    {
        try {
            $synchronizer = new Synchronizer();
            $synchronizer->sync();
        } catch (\Exception $err) {
            $_SESSION['WDR_FLASH'] = 'Synchronizacja nie powiodła się.';            
        } 
        $this->redirectToPage('wdr-gsheets-importer');
    }

    private function slugify(string $string): string 
    {
        $lowercaseString = strtolower($string);
        $hyphenatedString = str_replace(' ', '-', $lowercaseString);
        return $hyphenatedString;
    }

    private function redirectToPage(string $page): void 
    {
        header('Location: /wp-admin/admin.php?page=' . $page);
    }
} 