<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = ['ketinggian', 'parameter', 'nilai'];

    protected $appends = ['value'];

    protected $with = ['setting'];

    public function setting()
    {
        return $this->belongsTo(SensorSetting::class, 'parameter', 'parameter');
    }

    public function getValueAttribute()
    {
        return eval("return " . str_replace('data', $this->nilai, $this->setting->value_formatter) . ";");
    }
}
