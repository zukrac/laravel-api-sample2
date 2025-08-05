<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Objecto>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => null,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'apartment_number' => $this->faker->randomNumber(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
