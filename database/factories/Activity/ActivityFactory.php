<?php

namespace Database\Factories\Activity;

use App\Models\Activity\Activity;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "project_id" => fn () => Project::factory()->create()->getKey(),
            "description" => $this->faker->sentence,
        ];
    }
}
