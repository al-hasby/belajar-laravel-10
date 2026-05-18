<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'image' => Str::random(16).'.jpg',
            'title' => fake()->sentence(3),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}

