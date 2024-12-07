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
        $json = File::get(database_path('seeders/data/Township.json'));

        $townships = json_decode($json, true);

        foreach ($townships as $township) {
            Township::firstOrCreate(attributes: [
                'name' => $township['TownshipName'],
                'code' => $township['TownshipCode'],
                'state_code' => $township['StateCode'],
            ]);
        }
    }
}
