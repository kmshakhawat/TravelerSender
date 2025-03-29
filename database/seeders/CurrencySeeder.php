<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'NGN',
                'symbol' => '₦',
                'exchange_rate' => '0.0000',
            ],
            [
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => '0.0000',
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
