<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/region.json'));

        $data = json_decode($json, true);

        foreach ($data['data'] as $state) {
            State::firstOrCreate([
                'name' => $state['eng'],
            ]);
        }
    }
}
