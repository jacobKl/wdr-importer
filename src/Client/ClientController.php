<?php 

namespace WdrGsheetsImporter\Client;

use WdrGsheetsImporter\Database\Database;

class ClientController {
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getMakes()
    {
        header('Access-Control-Allow-Origin: *');
        wp_send_json($this->database->getMakes());
    }

    public function getModels()
    {
        header('Access-Control-Allow-Origin: *');
        $makeId = (int)$_GET['make_id'];
        $models = $this->database->getModels($makeId);

        wp_send_json($models);
    }

    public function getServices()
    {
        header('Access-Control-Allow-Origin: *');
        $makeId = (int)$_GET['make_id'];
        $modelId = (int)$_GET['model_id'];
        $categoryId = (int)$_GET['category_id'];

        $columns = [];

        if ($categoryId) {
            $category = $this->database->getCategory($categoryId);
            $columns = explode(';', $category->getSheetColumns());
        }

        $services = $this->database->getServices($makeId, $modelId, $columns);

        wp_send_json($services);
    }

    public function getCategories() 
    {
        header('Access-Control-Allow-Origin: *');
        $categories = $this->database->getCategoriesForApp($makeId, $modelId);

        wp_send_json($categories);
    }
}