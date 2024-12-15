<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Admin;
use App\Models\SystemBalance;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();
        $systemBalance = SystemBalance::first();
        $users = User::all();

        // Create 50 deposit transactions
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $amount = rand(100, 1000);
            $date = $this->randomDate();

            if ($amount <= $systemBalance->balance) {
                Transaction::make(TransactionType::DEPOSIT, $amount, $user, $admin, null, $date);
            }
        }

        // Create 50 withdrawal transactions
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $amount = rand(100, 1000);
            $date = $this->randomDate();

            if ($amount <= $user->balance) {
                Transaction::make(TransactionType::WITHDRAW, $amount, $admin, $user, null, $date);
            }
        }

        // Create 100 transfer transactions
        for ($i = 0; $i < 100; $i++) {
            $fromUser = $users->random();
            $toUser = $users->where('id', '!=', $fromUser->id)->random();
            $amount = rand(100, 1000);
            $date = $this->randomDate();

            if ($amount <= $fromUser->balance) {
                Transaction::make(TransactionType::WITHDRAW, $amount, $toUser, $fromUser, null, $date);
            }
        }
    }

    private function randomDate()
    {
        $start = Carbon::now()->subMonths(6);
        $end = Carbon::now();

        return Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp));
    }
}
