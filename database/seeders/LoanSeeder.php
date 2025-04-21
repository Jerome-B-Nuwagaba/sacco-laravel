<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all existing customer users
        $customers = User::where('role', 'customer')->get();

        // Get all existing loan types
        $loanTypes = LoanType::all();

        if ($customers->count() > 0 && $loanTypes->count() > 0) {
            // Create a number of loans for each customer
            $customers->each(function ($customer) use ($loanTypes) {
                // Create a random number of loans (between 1 and 3) for each customer
                $numberOfLoans = rand(1, 2);

                for ($i = 0; $i < $numberOfLoans; $i++) {
                    Loan::factory()->create([
                        'customer_id' => $customer->id,
                        'loan_type_id' => $loanTypes->random()->id,
                    ]);
                }
            });

            // You can also create some additional loans not specifically tied to each customer
            Loan::factory()->count(50)->create([
                'customer_id' => $customers->random()->id,
                'loan_type_id' => $loanTypes->random()->id,
            ]);
        } else {
            $this->command->warn("No customers or loan types found. Please seed users and loan types first.");
        }
    }
}