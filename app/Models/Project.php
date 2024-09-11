<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Project extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'client_id',
        'installation_location',
        'installation_type',
        'equipments' // Equipamentos armazenados como JSON
    ];

    // Cast para o campo `equipments` como JSON
    protected $casts = [
        'equipments' => 'array'
    ];

    // Relacionamento entre Project e Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
