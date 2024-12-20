<?php

namespace Database\Factories;

use App\Enums\InvoiceStatusEnum;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'invoice_number' => rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999),
            'invoice_date' => $this->faker->dateTimeBetween(Carbon::now()->subMonths(2), Carbon::now()->addMonths(3)),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(InvoiceStatusEnum::values()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'customer_id' => Customer::factory(),
        ];
    }
}
