<?php 

namespace WdrGsheetsImporter\Database\Model;

class SettingsModel {
    private int $id;
    private string $sheet;
    private string $confFile;
    private string $cron;

    public function __construct(
        int $id,
        string $sheet,
        string $confFile,
        string $cron
    ) {
        $this->id = $id;
        $this->sheet = $sheet;
        $this->confFile = $confFile;
        $this->cron = $cron;
    }

    public static function fromDb(array $row): self 
    {
        return new self(
            $row['id'],
            $row['sheet'],
            $row['conf_file'],
            $row['cron']
        );
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getSheet(): string 
    {
        return $this->sheet;
    }

    public function getConfFile(): string 
    {
        return $this->confFile;
    }

    public function getCron(): string 
    {
        return $this->cron;
    }
}