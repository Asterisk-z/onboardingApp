<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationProcessController extends Controller
{
    public function all_institutions(Request $request)
    {
        $data = Application::whereNotIn('status', [0]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", ApplicationResource::collection($data));
    }
}
