<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //

    public function index()
    {
        if (request('config')) {
            $system_configs = SystemSetting::where('name', request('config'))->first();
        } else {
            $system_configs = SystemSetting::all();
        }

        return response()->json([
            "status" => true,
            "statusCode" => "00",
            "message" => "Configs found",
            "data" => $system_configs,
        ]);
    }
}
