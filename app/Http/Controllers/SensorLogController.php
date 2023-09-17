<?php

namespace App\Http\Controllers;

use App\SensorLog;
use App\SensorSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return SensorLog::when($request->dateRange, function ($q) use ($request) {
            return $q->whereRaw('DATE(created_at) BETWEEN ? AND ?', $request->dateRange);
        })
            ->orderBy($request->sort ?: 'created_at', $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $data = [];

        foreach ($input as $parameter => $nilai) {
            if ($parameter == 'api_token') continue;

            $setting = SensorSetting::where('parameter', $parameter)->first();

            if (!$setting) {
                return response(['message' => 'Parameter ' . $parameter . ' belum didefinisikan'], 422);
            }

            $data[] = [
                'ketinggian' => $setting->height,
                'parameter' => $parameter,
                'nilai' => $nilai,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        try {
            DB::table('sensor_logs')->insert($data);
            return [
                'success' => true,
                'message' => 'OK',
            ];
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function getLastData(Request $request)
    {
        $data = SensorLog::where('parameter', $request->parameter)->latest()->first();

        if (!$data) {
            return response(['message' => 'data not found'], 404);
        }

        if ($request->unit == 'C') {
            return round(($data->value - 32) * 5 / 9, 1);
        }

        if ($request->unit == 'km/h') {
            return round($data->value * 1.60934);
        }

        if ($request->unit == 'mm') {
            return round($data->nilai * 0.2);
        }

        return $data->value;
    }

    public function getTekanan(Request $request)
    {
        $value = [];
        $category = [];

        $now = Carbon::create(0, 1, 1, date('G'));
        for ($i = 0; $i < 6; $i++) {
            $category[] = $now->format('H:i');
            $log = SensorLog::where('parameter', $request->parameter)
                ->whereRaw('DATE(created_at) = ? AND HOUR(created_at) = ?', [$request->date, $now->format('H')])
                ->first();

            $now->subHour();

            if (!$log) {
                $value[] = null;
                continue;
            }

            $value[] = $request->unit == 'hPa' ? round($log->value * 33.86389, 2) : round($log->value, 2);
        }

        return [
            'value' => array_reverse($value),
            'category' => array_reverse($category),
            'unit' => $request->unit ?: 'inHg'
        ];
    }

    public function exportToExcel(Request $request)
    {
        return SensorLog::when($request->dateRange, function ($q) use ($request) {
            return $q->whereRaw('DATE(created_at) BETWEEN ? AND ?', $request->dateRange);
        })->orderBy($request->sort ?: 'created_at', $request->order == 'ascending' ? 'asc' : 'desc')->get();
    }

    public function getTerbitTerbenam(Request $request)
    {
        $data = file_get_contents('https://api.sunrise-sunset.org/json?lat=8.5996&lng=116.1522&formatted=0');
        $data = json_decode($data);

        return [
            'terbit' => (new Carbon($data->results->sunrise))->addHours(8)->format('H:i:s'),
            'terbenam' => (new Carbon($data->results->sunset))->addHours(8)->format('H:i:s'),
        ];
    }

    public function getLastUpdate()
    {
        $data = SensorLog::latest()->first();
        return $data ? $data->created_at : null;
    }

    public function getLogAngin()
    {
        // [
        //       {
        //         type: "bar",
        //         data: [1, 2, 3, 4, 3, 5, 1, 4],
        //         coordinateSystem: "polar",
        //         name: "0-2mph",
        //         stack: "a"
        //       },
        //       {
        //         type: "bar",
        //         data: [2, 4, 6, 1, 3, 2, 1, 3],
        //         coordinateSystem: "polar",
        //         name: "2-4mph",
        //         stack: "a"
        //       },
        //       {
        //         type: "bar",
        //         data: [1, 2, 3, 4, 1, 2, 5, 2],
        //         coordinateSystem: "polar",
        //         name: "4-6mph",
        //         stack: "a"
        //       }
        // ]
        // grouping data berdasarkan kecepatan angin
        $sql = "

        ";

        $legend = ['0-2mph', '2-4mph', '4-6mph'];
        $series = [
            [
                'type' => 'bar',
                'data' => [1, 2, 3, 4, 3, 5, 1, 4],
                'coordinateSystem' => 'polar',
                'name' => '0-2mph',
                'stack' => 'a'
            ],
            [
                'type' => 'bar',
                'data' => [1, 2, 3, 4, 3, 5, 1, 4],
                'coordinateSystem' => 'polar',
                'name' => '2-4mph',
                'stack' => 'a'
            ],
            [
                'type' => 'bar',
                'data' => [1, 2, 3, 4, 3, 5, 1, 4],
                'coordinateSystem' => 'polar',
                'name' => '4-6mph',
                'stack' => 'a'
            ],
        ];

        return [
            'series' => $series,
            'legend' => $legend
        ];
    }
}
