<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

abstract class Message
{
    protected $type;
    private $code;
    private $description;

    private string | null $title;

    public function __construct(string $description, string $code, string | null $title = null)
    {
        $this->description = $description;
        $this->code = $code;
        $this->title = $title;
    }

    public function toJson($options = 0): array
    {
        $array =  [
            'type' => $this->type,
            'code' => $this->code,
            'description' => $this->description,
            'title' => $this->title
        ];

        if ($this->title === null) {
            unset($array['title']);
        }
        return $array;
    }

    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }

    protected function setCode(string $code): void
    {
        $this->code = $code;
    }

    protected function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->code;
    }

    abstract public function store(string $name): void;
    abstract public function update(string $name): void;
    abstract public function destroy(string $name): void;
    abstract public function restore(string $name): void;
}
