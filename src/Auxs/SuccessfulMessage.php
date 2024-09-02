<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

class SuccessfulMessage extends Message
{
    protected $type = 'success';

    public function __construct(string $description = '', string $code = '')
    {
        parent::__construct($description, $code);
    }

    public function store(string $name): void
    {
        $this->setDescription("{$name} created Successful");
        $this->setCode('STORED');
    }

    public function update(string $name): void
    {
        $this->setDescription("{$name} updated Successful");
        $this->setCode('UPDATED');
    }

    public function destroy(string $name): void
    {
        $this->setDescription("{$name} deleted Successful");
        $this->setCode('DESTOYED');
    }

    public function restore(string $name): void
    {
        $this->setDescription("{$name}  restored Successful");
        $this->setCode('RESTORED');
    }

    public function get(string $name): void
    {
        $this->setDescription("{$name} obtained Successful");
        $this->setCode('OBTEAINED');
    }

    public function getAll(string $name): void
    {
        $this->setDescription("Successful");
        $this->setCode('OBTEAINEDS');
    }

    public function relation(string $relation): void
    {
        $this->setDescription("Successful");
        $this->setCode('OBTEAINED');
    }
}
