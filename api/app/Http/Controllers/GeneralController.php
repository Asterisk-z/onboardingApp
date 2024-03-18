<?php

namespace App\Http\Controllers;

use App\Models\FmdqSystems;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function fmdqSystems(Request $request) 
    {
        return response()->json([
            'status' => true,
            'statusCode' => '00',
            'message' => 'Here you go',
            'data' => FmdqSystems::all()
        ]);
    }
}
