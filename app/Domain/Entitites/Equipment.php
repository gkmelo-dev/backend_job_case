<?php

namespace App\Domain\Entities;

class Equipment
{
    public $id;
    public $name;
    public $category;
    public $quantity;

    public function __construct($id, $name, $category, $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
    }
}
