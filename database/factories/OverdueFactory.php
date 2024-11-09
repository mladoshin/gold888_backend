<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OverdueStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Overdue>
 */
class OverdueFactory extends Factory
{
    const OVERDUE_STATUS_ARRAY = [
        OverdueStatus::TRANSFERRED_TO_A_LAWYER,
        OverdueStatus::SUSPENDED,
        OverdueStatus::WITHOUT_DOCUMENTS,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(self::OVERDUE_STATUS_ARRAY),
            'amount' => $this->faker->numberBetween(0, 1000000),
            'returned' => $this->faker->numberBetween(0, 1000000),
            'user' => $this->faker->userName,
            'return_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
