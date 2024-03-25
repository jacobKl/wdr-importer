<?php 

namespace WdrGsheetsImporter\Database\Model;

class CommentModel {
    private int $id;
    private string $name;
    private string $comment;

    public function __construct(
        int $id,
        string $name,
        string $comment
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
    }

    public static function fromDb(array $row): self 
    {
       return new self(
            $row['id'],
            $row['name'],
            $row['comment']
        );
    }

    public function update(string $name, string $comment) {
        if ($name) $this->name = $name;
        if ($comment) $this->comment = $comment;
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getComment(): string 
    {
        return $this->comment;
    }
}