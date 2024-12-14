<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemBalance = new \App\Models\SystemBalance;
        $systemBalance->balance = 10000000;
        $systemBalance->save();
    }
}
