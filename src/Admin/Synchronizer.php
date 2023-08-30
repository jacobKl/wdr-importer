<?php 

namespace WdrGsheetsImporter\Admin;

use Google\Client;
use Google\Service\Sheets;
use WdrGsheetsImporter\Database\Model\SettingsModel;
use WdrGsheetsImporter\Database\Database;

class Synchronizer {
    private Database $database;

    public function __construct() 
    {   
        $this->database = new Database();
    }

    public function sync() {
        $settings = $this->getSettings();
        $credentialsFile = constant('WDR_GSHEETS_PLUGIN') . '/credentials.json';

        $client = new Client();
        $client->setAuthConfig($credentialsFile);

        $client->addScope(Sheets::SPREADSHEETS_READONLY);
        $service = new Sheets($client);

        $response = $service->spreadsheets_values->get($settings->getSheet(), 'A1:ZZ');
        
        $this->import($response['values']);
    }

    private function import(array $values): void 
    {
        $this->clearDb();

        $headers = $values[0]; unset($values[0]);
        $makes = array_unique(array_map(function (array $row) {
            return trim($row[0]);
        }, $values));

        foreach ($makes as $key => $make) {
            $this->database->createMake($key, $make);
        }

        $makesAssoc = array_flip($makes);

        $models = array_map(function (array $row) use ($makesAssoc) {
            return [ 'name' => $row[1], 'make' => $makesAssoc[trim($row['0'])]];
        }, $values);

        foreach ($models as $key => $model) {
            $this->database->createModel($key, $model['name'], $model['make']);
        }

        $services = [];

        foreach ($values as $row) {
            $makeName = trim($row[0]);
            $makeId = $makesAssoc[$makeName];

            $modelName = $row[1];
            $modelId = array_keys(array_filter($models, function (array $item) use ($makeId, $modelName) {
                return ($item['name'] == $modelName && $item['make'] == $makeId);
            }))[0];

            $i = 2;
            while (isset($headers[$i])) {
                $services[] = ['make_id' => $makeId, 'model_id' => $modelId, 'column_name' => $headers[$i], 'price' => isset($row[$i]) ? $row[$i] : 0];
                $i++;
            }
        }

        foreach ($services as $service) {
            $this->database->createService($service);
        }
    }

    private function clearDb(): void 
    {
        $this->database->clearDb();   
    }

    private function getSettings(): SettingsModel 
    {
        return $this->database->getSettings();
    }
}