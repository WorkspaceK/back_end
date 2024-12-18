<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->name(),
            'description'=> $this->faker->text(),
            'publication_type_id'=> $this->faker->randomElement([1,2,3,4,5,6,7,8,9]),
            'organization_name'=> $this->faker->company(),
            'ISSN'=> $this->faker->isbn10(),
            'cover_image'=> $this->faker->imageUrl(),
            'published_year'=> $this->faker->year(),
            'status_id'=> $this->faker->randomElement([0,1]),
            'full_text'=> $this->faker->text(),
            'main_person_id'=> $this->faker->randomElement([1,2,3,4,5,6,7,8,9]),
        ];
    }
}
