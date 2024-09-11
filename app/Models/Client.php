<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpfCnpj'
    ];

    // Relacionamento entre Client e Project
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
