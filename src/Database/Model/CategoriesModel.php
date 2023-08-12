<?php 

namespace WdrGsheetsImporter\Database\Model;

class CategoriesModel {
    private int $id;
    private string $name;
    private string $sheetColumns;
    private string $image;

    public function __construct(
        int $id,
        string $name,
        string $sheetColumns,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sheetColumns = $sheetColumns;
        $this->image = $image;
    }

    public static function fromDb(array $row): self 
    {
       return new self(
            $row['id'],
            $row['name'],
            $row['sheet_columns'],
            $row['image']
        );
    }

    public function update(string $name, string $sheetColumns, string $image) {
        if ($name) $this->name = $name;
        if ($sheetColumns) $this->sheetColumns = $sheetColumns;
        if ($image) $this->image = $image;
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getSheetColumns(): string 
    {
        return $this->sheetColumns;
    }

    public function getImage(): string 
    {
        return $this->image;
    }
}