<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function primary()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'primary',
            ];
        });
    }

    public function secondary()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'secondary'
            ];
        });
    }
}
