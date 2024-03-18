<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
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

        $application_list = Application::where('applications.submitted_by', auth()->user()->id);

        $application_data = Utility::applicationData($application_list);
        $application_data = $application_data->get();

        $data = [
            'complaints' => $complaints,
            'applications' => $applications,
            'ars' => $ars,
            "application_list" => ApplicationResource::collection($application_data),
        ];
        return successResponse('Successfully', $data);

    }
}
