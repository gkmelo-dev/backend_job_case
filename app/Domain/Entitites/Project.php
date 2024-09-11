<?php

namespace App\Domain\Entities;

class Project
{
    public $id;
    public $clientId;
    public $location;
    public $installationType;
    public $equipment;

    public function __construct($id, $clientId, $location, $installationType, $equipment)
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->location = $location;
        $this->installationType = $installationType;
        $this->equipment = $equipment;
    }
}
