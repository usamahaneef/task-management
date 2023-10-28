<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->sentence(7),
            'due_date' => $this->faker->date,
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High', 'Urgent']),
            'status' => $this->faker->randomElement(['Incomplete', 'Complete']),
        ];
    }
}
