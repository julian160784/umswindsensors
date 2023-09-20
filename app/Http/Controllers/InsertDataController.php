<?php

namespace App\Http\Controllers;

use App\SensorLog;
use App\SensorSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsertDataController extends Controller
{
    public function insert()
    {
        $content = Storage::get('datasensor/realtimegauges.txt');
        $json = json_decode($content);
        $timeUTC = $json->timeUTC;
        $timeUTC = explode(",", $timeUTC);
        $strTimeUTC = $timeUTC[0] . "-" . $timeUTC[1] . "-" . $timeUTC[2] . " " . $timeUTC[3] . ":" . $timeUTC[4] . ":" . $timeUTC[5];
        $sensorLog = SensorLog::orderBy('id', 'desc')->first();
        $secondSensor = strtotime($sensorLog->created_at);
        $secondFile = strtotime($strTimeUTC);

        if ($secondFile > $secondSensor) {


            $sensorsetting = SensorSetting::all();
            // dd ($sensorsetting[0]->parameter);
            foreach ($json as $key => $value) {
                foreach ($sensorsetting as $s) {
                    if ($key == $s['parameter']) {
                        $data[] = [
                            'ketinggian' => $s->height,
                            'parameter' => $key,
                            'nilai' => $value,
                            'created_at' => $strTimeUTC,
                            'updated_at' => $strTimeUTC
                        ];

                        SensorLog::insert($data);
                    }
                }
            }

        }
    }
}
