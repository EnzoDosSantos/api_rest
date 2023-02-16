<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Storage;
use DB;

class AnimalSeed extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk("local")->get("json/animals.json");
        $animals = json_decode($json, true);

        foreach($animals as $a){
            DB::insert('insert into cat_animal (name, sound) values (?, ?)', [$a["name"], $a["sound"]]);
        }
    }
}
