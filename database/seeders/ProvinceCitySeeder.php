<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use File;
use App\Models\Province;
use App\Models\City;

class ProvinceCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Province::truncate();
        City::truncate();
        Schema::enableForeignKeyConstraints();
  
        $provinceJsonFile = json_decode(File::get("database/data/province.json"));
        $cityJsonFile = json_decode(File::get("database/data/city.json"));

        echo "Seeding Province. Please wait...\n";

        foreach ($provinceJsonFile as $key => $value) {
            Province::create([
                "code" => $value->kode,
                "name" => $value->nama
            ]);
        }

        echo "Seeding City. Please wait...\n";

        foreach ($cityJsonFile as $key => $value) {
            City::create([
                "code" => $value->kode,
                "name" => $value->nama,
            ]);
        }
    }
}
