<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorSetting extends Model
{
    protected $fillable = [
        'parameter', 'description', 'height',
        'min_value', 'max_value', 'unit',
        'value_formatter', 'value_description',
        'secondary_unit', 'chart_type'
    ];

    protected $casts = [
        'value_description' => 'json',
        'secondary_unit' => 'json'
    ];

    public static function decimalToDate($decimal)
    {
        $binary = str_pad(decbin($decimal), 16, '0', STR_PAD_LEFT);
        return trim(substr($binary, 0, 7), "0");
        $tahun = 2000 + bindec(trim(substr($binary, 0, 7), "0"));
        $bulan = bindec(trim(substr($binary, 8, 5), "0"));
        $tanggal = bindec(trim(substr($binary, 12, 5), "0"));
        return $tahun."-".$bulan."-".$tanggal;
    }

    public function logs()
    {
        return $this->hasMany(SensorLog::class, 'parameter', 'parameter');
    }
}
