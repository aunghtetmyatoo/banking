<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/User.json'));

        $users = json_decode($json, true);

        foreach ($users as $user) {
            $user = User::firstOrCreate([
                'name' => $user['FullName'],
                'username' => $user['UserName'],
                'email' => $user['Email'],
                'mobile' => $user['MobileNo'],
                'password' => bcrypt('password'),
                'address' => $user['Address'],
                'code' => $user['UserCode'],
                'state_id' => 1,
                'township_id' => 1,
            ]);

            $user->assignRole('User');
        }
    }
}
