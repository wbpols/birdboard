<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $project = new Project();

        return [
            $project->getForeignKey() => $project->factory()->create(),
            "body" => $this->faker->sentence,
            "completed" => false,
        ];
    }
}
