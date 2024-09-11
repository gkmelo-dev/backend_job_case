<?php

namespace App\Domain\Entities;

class Client
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $cpfCnpj;

    public function __construct($id, $name, $email, $phone, $cpfCnpj)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->cpfCnpj = $cpfCnpj;
    }
}
