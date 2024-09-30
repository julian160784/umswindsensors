<?php

namespace App\Http\Controllers;

use App\SensorLog;
use App\SensorSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsertDataController extends Controller
{   
    public function insert()
    {
        $content = Storage::get('datasensor/realtimegauges2.txt');
        $json = json_decode($content);
        $sensorLog = SensorLog::orderBy('id', 'desc')->first();
        if (isset($sensorLog->created_at)) 
        {
            $secondSensor = strtotime($sensorLog->created_at);
        } 
        else 
        {
            $secondSensor = 0;
        }

        $secondFile = strtotime($json->date);

        //$existrg2 = Storage::exists('datasensor/realtimegauges2.txt');


        if ($secondFile > $secondSensor) 
        {
            $sensorsetting = SensorSetting::all();
            // dd ($sensorsetting[0]->parameter);
            foreach ($json as $key => $value) 
            {
                foreach ($sensorsetting as $s) 
                {
                    if ($key == $s['parameter'] && $key != 'forecast')
                    {
                        $data = [
                            'ketinggian' => $s->height,
                            'parameter' => $key,
                            'nilai' => $value,
                            'created_at' => $json->date
                            //'updated_at' =>$json->date
                        ];
                        SensorLog::insert($data);
                    }
                }
            }
          

            $rg2 = Storage::get('datasensor/realtimegauges.txt');
            $json2 = json_decode(($rg2));
            foreach ($json2 as $key => $value) 
            {
                foreach ($sensorsetting as $s) 
                {
                    if ($key == $s['parameter'] && $key != 'forecast')
                    {
                        $data = [
                                'ketinggian' => $s->height,
                                'parameter' => $key,
                                'nilai' => $value,
                                'created_at' =>$json->date
                                //'updated_at' => $json->date
                        ];
                        SensorLog::insert($data);
                    }
                }
            }
            
        }
    }

}