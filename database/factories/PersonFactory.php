<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identification'=> $this->faker->buildingNumber(),
            'first_name'=> $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'email'=> $this->faker->unique()->safeEmail(),
            'phone_number'=> $this->faker->phoneNumber(),
            'avatar'=> $this->faker->imageUrl(),
            'degree_id'=> $this->faker->numberBetween(1,2),
            'academic_rank_id'=> $this->faker->numberBetween(1,2),
        ];
    }
}
