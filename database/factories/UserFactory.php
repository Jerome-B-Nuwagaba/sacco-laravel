<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; 
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['customer', 'loan_officer']), 
            'loan_officer_id' => null, 
            'created_at' => now(),
            'updated_at' => now(),
            
        ];
    }

    /**
     * Indicate that the user is a customer.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'customer',
                'loan_officer_id' => null,
            ];
        });
    }

    /**
     * Indicate that the user is a loan officer.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function loanOfficer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'loan_officer',
                'loan_officer_id' => null, 
            ];
        });
    }
}