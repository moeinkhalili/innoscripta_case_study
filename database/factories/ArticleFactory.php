<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'body' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'thumbnail' => $this->faker->imageUrl(),
            'published_at' => Carbon::now()->subDays(rand(1, 10)),
            'provider' => $this->faker->word(),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
