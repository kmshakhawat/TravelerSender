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
                'exchange_rate' => '',
            ],
            [
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => '',
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
