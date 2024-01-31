<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Complaint;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardControler extends Controller
{
    public function adminDashboard(Request $request)
    {
        $complaints = Complaint::count();
        $applications = Application::count();
        $ars = User::whereIn('role_id', [Role::ARINPUTTER, Role::ARAUTHORISER])->where('is_del', 0)->count();
        $data = [
            'complaints' => $complaints,
            'applications' => $applications,
            'ars' => $ars,
        ];
        return successResponse('Successfully', $data);

    }

    public function arDashboard(Request $request)
    {

        $complaints = Complaint::where('user_id', auth()->user()->id)->count();
        $applications = Application::where('institution_id', auth()->user()->institution_id)->count();
        $ars = User::whereIn('role_id', [Role::ARINPUTTER, Role::ARAUTHORISER])->where('institution_id', auth()->user()->institution_id)->where('is_del', 0)->count();

        $application = Application::where('submitted_by', auth()->user()->id)->first();

        $application_list = Application::where('submitted_by', auth()->user()->id)->get();
        // $application_list = Conversion::where('submitted_by', auth()->user()->id)->get();
        // $application_list = Addition::where('submitted_by', auth()->user()->id)->get();

        $data = [
            'complaints' => $complaints,
            'applications' => $applications,
            'show_application' => $application->show_form,
            'ars' => $ars,
            "application_list" => $application_list,
        ];
        return successResponse('Successfully', $data);

    }
}
