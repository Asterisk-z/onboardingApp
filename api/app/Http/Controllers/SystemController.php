<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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

    public function executeCommands()
    {
        // Execute the desired commands using Artisan and exec
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('queue:restart');
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('storage:link');

        return response()->json(['message' => 'Commands executed successfully']);
    }

    public function clearModel($modelName)
    {
        $modelClass = "App\Models\\" . $modelName;

        if (class_exists($modelClass)) {
            $model = new $modelClass();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $model->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json(['message' => "Model $modelName truncated successfully"]);
        } else {
            return response()->json(['message' => "Model $modelName not found"]);
        }
    }

    public function refreshDatabase($modelName)
    {

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');

        return response()->json(['message' => 'Commands executed successfully']);

    }

    public function linkStorage()
    {

        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        Artisan::call('storage:link');

        return response()->json(['message' => 'Commands executed successfully']);

    }
}
