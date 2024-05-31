<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Institution;
use App\Models\MembershipCategory;
use App\Models\Role;
use App\Models\Status;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class ApplicationProcessController extends Controller
{

    public function applications(Request $request)
    {

        $application_list = Application::where('applications.submitted_by', auth()->user()->id);

        if (request('application_type')) {
            $application_list = $application_list->where('applications.application_type', request('application_type'));
        }

        $application_data = Utility::applicationData($application_list);
        $application_data = $application_data->get();

        $data = [
            "application_list" => ApplicationResource::collection($application_data),
        ];

        return successResponse("Here you go", $data ?? []);
    }

    public function all_institutions(Request $request)
    {
        $data = Application::where('applications.institution_id', '!=', null);
        $data = Utility::applicationDetails($data);
        $data = $data->get();
        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function all_institution_report(Request $request)
    {
        $data = Application::where('applications.institution_id', '!=', null);
        $data = Utility::applicationDetails($data);
        $data = $data->get();

        $table = "<table>
            <thead>
                <tr>
                    <th scope='col'>Membership ID</th>
                    <th scope='col'>Institution</th>
                    <th scope='col'>Category</th>
                    <th scope='col'>Address</th>
                    <th scope='col'>Phone Number</th>
                    <th scope='col'>Email address</th>
                    <th scope='col'>Website</th>
                    <th scope='col'>Status</th>
                    <th scope='col'>Sign-on date</th>
                <tr>
            </thead>
            <tbody>";
        foreach ($data as $setData) {

            $application = Application::find($setData->application_id);

            $table .= "<tr>
                            <td scope='row'>{$application->reg_id}</td>
                            <td>{$setData->companyName}</td>
                            <td>{$setData->category_name}</td>
                            <td>{$setData->registeredOfficeAddress}</td>
                            <td>{$setData->companyTelephoneNumber}</td>
                            <td>{$setData->companyEmailAddress}</td>
                            <td>{$setData->corporateWebsiteAddress}</td>
                            <td>{$setData->status_description}</td>
                            <td>{$application->created_at}</td>
                        </tr>";
        }

        $table .= "</tbody>
            </table>";

        return successResponse("Here you go", ['report' => ApplicationResource::collection($data),  'report_url' => route('downloadReport', base64_encode($table))]);
    }

    public function get_application(Request $request)
    {
        $data = Application::where('uuid', request('application_uuid'))->first();
        // $data = Utility::applicationDetails($data);
        // $data = $data->first();
        return successResponse("Here you go", $data);
    }

    public function conversionRequest(Request $request)
    {
        $request->validate([
            'old_category' => 'required|exists:membership_categories,id',
            'new_category' => 'required|exists:membership_categories,id',
        ]);

        $errorMsg = "Unable to complete your request at this point.";

        if (Application::where('membership_category_id', request('old_category'))->where('institution_id', auth()->user()->institution_id)->where('completed_at', null)->exists() ||
            Application::where('membership_category_id', request('new_category'))->where('institution_id', auth()->user()->institution_id)->whereIn('application_type_status', [Application::typeStatus['ASP'], Application::typeStatus['ASC']])->exists()) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }
        $institution = Institution::find(auth()->user()->institution_id);
        $old_category = MembershipCategory::find(request('old_category'));
        $data = Application::where('applications.id', auth()->user()->application[0]->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $status = new Status();
        $status->office = Application::office['AP'];
        $status->status = Application::statuses['PEN'];
        $status->save();

        $application = Application::create([
            'institution_id' => $institution->id,
            'submitted_by' => auth()->user()->id,
            'membership_category_id' => request('new_category'),
            'old_membership_category_id' => request('old_category'),
            'status' => $status->id,
            'office_to_perform_next_action' => Application::office['AP'],
            'application_type' => Application::type['CON'],
            'application_type_status' => Application::typeStatus['ASP'],
        ]);

        $application->status()->save($status);

        $Meg = Utility::getUsersByCategory(Role::MEG);
        Notification::send($Meg, new InfoNotification(MailContents::megConversionRequestMail($data->company_name, $old_category->name), MailContents::megConversionRequestTitle()));

        logAction(auth()->user()->email, 'Conversion Request Sent', "Conversion Request Sent {$data->company_name}.", $request->ip());

        return successResponse("You have started the conversion process");
    }

    public function additionRequest(Request $request)
    {
        $request->validate([
            'new_category' => 'required|exists:membership_categories,id',
        ]);

        $errorMsg = "Unable to complete your request at this point.";

        if (Application::where('membership_category_id', request('new_category'))->where('institution_id', auth()->user()->institution_id)->whereIn('application_type_status', [Application::typeStatus['ASP'], Application::typeStatus['ASC']])->exists()) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }
        $institution = Institution::find(auth()->user()->institution_id);
        $data = Application::where('applications.id', auth()->user()->application[0]->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $status = new Status();
        $status->office = Application::office['AP'];
        $status->status = Application::statuses['PEN'];
        $status->save();

        $application = Application::create([
            'institution_id' => $institution->id,
            'submitted_by' => auth()->user()->id,
            'membership_category_id' => request('new_category'),
            'status' => $status->id,
            'office_to_perform_next_action' => Application::office['AP'],
            'application_type' => Application::type['ADD'],
            'application_type_status' => Application::typeStatus['ASP'],
        ]);

        $application->status()->save($status);

        $Meg = Utility::getUsersByCategory(Role::MEG);
        Notification::send($Meg, new InfoNotification(MailContents::megAdditionRequestMail($data->company_name), MailContents::megAdditionRequestTitle()));

        logAction(auth()->user()->email, 'Addition Request Sent', "Addition Request Sent {$data->company_name}.", $request->ip());

        return successResponse("You have started the addition process");

    }
}
