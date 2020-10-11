<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence,
            "description" => $this->faker->paragraph,
            "owner_id" => fn () => User::factory()->create()->getKey(),
        ];
    }
}
