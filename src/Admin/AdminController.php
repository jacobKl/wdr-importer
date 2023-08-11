<?php 

namespace WdrGsheetsImporter\Admin;

use WdrGsheetsImporter\Database\Database;
use WdrGsheetsImporter\Traits\TemplatingTrait;
use Google\Client;
use Google\Service\Sheets;

class AdminController {

    private const UPDATE_SETTINGS = 'update_settings';
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
        }
    }

    public function settings(): void
    {
        $settings = $this->database->getSettings();

        $view = $this->display('settings', [
            'sheet' => $settings->getSheet(),
            'conf_file' => 'credentials.json',
            'cron' => $settings->getCron(),
            'file_exists' => file_exists(constant('WDR_GSHEETS_PLUGIN') . '/credentials.json'),
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
    }
    
    public function categories(): void 
    {
        echo $this->display('categories', []);
    }
}