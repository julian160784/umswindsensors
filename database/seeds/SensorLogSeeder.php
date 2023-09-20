<?php

use App\SensorLog;
use Illuminate\Database\Seeder;

class SensorLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "ketinggian" => 100,
            "parameter" => 'data1',
            "nilai" => 60,
            "created_at" => now()
        ];

        SensorLog::insert($data);
    }
}
