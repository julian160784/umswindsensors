<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function artisan(Request $request)
    {
        $request->validate([
            'command' => 'required|not_in:down'
        ]);

        try {
            Artisan::call($request->command);
        } catch (\Exception $e) {
            return response(['message' => 'Command not found '. $e->getMessage()], 404);
        }

        return ['message' => 'Command success'];
    }
}
