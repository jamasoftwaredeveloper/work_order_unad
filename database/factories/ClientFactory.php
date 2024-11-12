<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nit' => $this->faker->unique()->numerify('#####'),  // Genera un NIT de 5 dígitos
            'name' => $this->faker->name(),  // Genera un nombre aleatorio
            'address' => $this->faker->address(),  // Genera una dirección aleatoria
            'business_name' => $this->faker->company(),  // Genera una razón social de empresa aleatoria
        ];
    }
}

