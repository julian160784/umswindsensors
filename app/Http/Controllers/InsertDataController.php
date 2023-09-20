<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsertDataController extends Controller
{
    public function insert() {
        $content = Storage::get('datasensor/realtimegauges.txt');
        dd ($content);
    }
}
