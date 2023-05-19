<?php

namespace Database\Factories\Domains\Customer\Models;

use App\Domains\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date,
            'phone_number' => str_replace('-' , '' , $this->faker->e164PhoneNumber),
            'email' => $this->faker->unique()->safeEmail,
            'bank_account_number' => $this->faker->iban,
        ];
    }
}
