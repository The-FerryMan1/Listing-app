<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => fake()->randomElement([1,2,4,5,6]),
            'title' => fake()->sentence(10),
            'desc' => fake()->paragraph(10),
            'tags' => fake()->randomElement([
                'Fintect, game',
                'AWS, Vue',
                'Js, React',
            ]),
            'email' =>fake()->email(),
            'link' =>fake()->url(),
            'approved' => fake()->randomElement([0,1])

        ];
    }
}
