<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //

    public function index(){
        return response()->json([
            "status" => true,
            "statusCode" => "00",
            "message" => "Configs found",
            "data" => SystemSetting::all()
        ]);
    }
}
