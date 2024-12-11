<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'dob' => $this->faker->date(),
            'city' => $this->faker->city(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
