<?php

namespace Library\Domain\Entities;

class User extends Person
{
    private ? string $id;
    private string $email;

    public function __construct(string $name, string $email, ?string $id = null)
    {
        parent::__construct($name);
        $this->email = $email;
        $this->id = $id;
    }

    public function getId(): ? string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setId()
    {
        $this->id = uniqid();
    }

    public function toArray() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail()
        ];
    }
}
