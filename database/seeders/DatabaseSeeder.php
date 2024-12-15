<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StateSeeder::class,
            TownshipSeeder::class,
            ShieldSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            SystemBalanceSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
