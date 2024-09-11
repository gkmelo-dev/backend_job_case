<?php

namespace App\Domain\Entities;

class Project
{
    public $id;
    public $clientId;
    public $location;
    public $installationType;
    public $equipments;

    public function __construct($id, $clientId, $location, $installationType, array $equipments = [])
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->location = $location;
        $this->installationType = $installationType;
        $this->equipments = $equipments;
    }
}
