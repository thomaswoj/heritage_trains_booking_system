<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_type')->truncate();

        DB::table('vehicle_type')->insert([
            [
                'id' => 1,
                'name' => 'Train',
            ]
        ]);
    }
}
