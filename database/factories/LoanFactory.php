<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(300000, 500000),
            'status' => $this->faker->randomElement(['pending', 'forwarded']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
            'loan_officer_id' => function () {
                return User::where('role', 'loan_officer')->inRandomOrder()->first()->id ?? null;
            },
        ];
    }
}