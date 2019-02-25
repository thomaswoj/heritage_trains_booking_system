<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->truncate();

        DB::table('stations')->insert([
            [
                'id' => 1,
                'name' => 'Station',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Engine Shed',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
