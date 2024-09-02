<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

final class ErrorMessage extends Message
{
    protected $type = 'error';

    public function __construct(string $description = '', string $code = '', string | null $title = null)
    {
        parent::__construct($description, $code, $title);
    }

    public function store(string $name): void
    {
        $this->setDescription("{$name} not created due to internal error");
        $this->setCode('NOT_STORED');
    }

    public function update(string $name): void
    {
        $this->setDescription("{$name} not updated due to internal error");
        $this->setCode('NOT_UPDATED');
    }

    public function destroy(string $name): void
    {
        $this->setDescription("{$name} not deleted due to internal error");
        $this->setCode('NOT_DESTOYED');
    }

    public function restore(string $name): void
    {
        $this->setDescription("{$name} not restored due to internal error");
        $this->setCode('NOT_RESTORED');
    }

    public function get(string $name): void
    {
        $this->setDescription("{$name} not obtained due to internal error");
        $this->setCode('NOT_OBTAINED');
    }

    public function getAll(string $name): void
    {
        $this->setDescription("Error trying to get list of {$name}");
        $this->setCode('NOT_OBTAINEDS');
    }

    public function relation(string $relation): void
    {
        $this->setDescription("There was an error while consulting {$relation}");
        $this->setCode('NOT_OBTAINED');
    }
}
