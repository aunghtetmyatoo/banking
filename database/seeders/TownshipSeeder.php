<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/region.json'));

        $data = json_decode($json, true);

        foreach ($data['data'] as $state_key => $state) {
            foreach ($state['districts'] as $district) {
                foreach ($district['townships'] as $township) {
                    Township::firstOrCreate([
                        'name' => $township['eng'],
                        'state_id' => $state_key + 1,
                    ]);
                }
            }
        }
    }
}
