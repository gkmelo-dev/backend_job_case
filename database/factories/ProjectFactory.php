<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'client_id' => \App\Models\Client::factory(),  // Creates a related client
            'installation_location' => $this->faker->randomElement(['BA', 'SP', 'RJ', 'MG']),
            'installation_type' => $this->faker->randomElement(['Laje', 'Fibrocimento (Madeira)', 'Solo']),
            'equipments' => json_encode([
                ['name' => 'Módulo', 'quantity' => $this->faker->randomDigitNotZero()],
                ['name' => 'Inversor', 'quantity' => $this->faker->randomDigitNotZero()]
            ]),
        ];
    }
}
