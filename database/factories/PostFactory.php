<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(10),
            'user_id' => 1,
        ];
    }
}
