<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    //

    public function report($data)
    {
        $data = request('data');
        $pdf = App::make('dompdf.wrapper');
        $tableData = null;

        if ($data == 'application_report') {
            $tableData = Utility::applicationReport();
        }

        if ($data == 'education_report') {
            $tableData = Utility::educationReport();
        }

        if ($data == 'representation_report') {
            $tableData = Utility::representativeReport();
        }

        if ($data == 'institution_application_report') {
            $tableData = Utility::institutionApplicationReport(request('key'));
        }

        if ($tableData) {

            $dataTable = $tableData;

            $title = str_replace('_', ' ', $data);

            $pdf->loadView('report', compact('dataTable', 'title'))->setPaper(array(0, 0, 800, 480));

            return $pdf->download("$data.pdf");
        }

    }

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

    public function refreshDatabase()
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
