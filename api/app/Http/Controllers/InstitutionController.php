<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Resources\InstitutionResource;
use App\Models\Application;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function listInstitution()
    {

        $query = Institution::where('is_del', '0');

        $institutions = $query->latest()->get();

        return successResponse('Successful', InstitutionResource::collection($institutions));

    }

    public function processStatusMEG(Request $request, Institution $institution)
    {

        $request->validate([
            'action' => 'required|in:approve,suspend',
        ]);

        $regID = $institution->getRegID();

        if ($request->action == 'approve') {

            $institution->is_del = 0;
            $institution->save();

            $applications = $institution->application;

            foreach ($applications as $application) {

                if ($application->type_status == Application::typeStatus['ASC']) {

                    Utility::applicationStatusHelper($application, Application::statuses['ACT'], Application::office['MEG'], Application::office['AP']);

                }

            }

            $ars = $institution->ars;
            foreach ($ars as $ar) {

                $ar->member_status = 'active';
                $ar->save();

            }

            $logTitle = 'Activate Institution';
            $logMessage = auth()->user()->full_name . " activated institution status of AR - $institution->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

        } else {

            $institution->is_del = 1;
            $institution->save();

            $applications = $institution->application;

            foreach ($applications as $application) {

                if ($application->type_status == Application::typeStatus['ASC']) {
                    Utility::applicationStatusHelper($application, Application::statuses['TER'], Application::office['AP'], Application::office['MEG']);
                }
            }

            $ars = $institution->ars;
            foreach ($ars as $ar) {

                $ar->member_status = 'suspended';
                $ar->save();

            }

            $logTitle = 'Suspend Institution';
            $logMessage = auth()->user()->full_name . " suspended  institution status of AR - $institution->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
        }

        return successResponse('Status Updated Successful', []);
    }
}
