<?php
namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationProcessTimestamp;
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

        // $application_list = Application::where('applications.submitted_by', auth()->user()->id);
        $application_list = Application::where('applications.institution_id', auth()->user()->institution_id);

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

        return successResponse("Here you go", ['report' => ApplicationResource::collection($data), 'report_url' => route('downloadReport', ['application_report'])]);
    }

    public function timestamp(Request $request)
    {
        $data = ApplicationProcessTimestamp::orderBy('created_at', 'desc')->get();
        return successResponse("Here you go", $data);
        // return successResponse("Here you go", ['report' => $data, 'report_url' => route('downloadReport', ['application_report'])]);
    }

    public function get_application(Request $request)
    {
        $data = Application::where('uuid', request('application_uuid'))->first();
        // $data = Utility::applicationDetails($data);
        // $data = $data->first();
        return successResponse("Here you go", $data);
    }

    public function get_application_disclosure(Request $request)
    {
        $application = Application::where('uuid', request('application_uuid'))->first();

        $membershipCategory = MembershipCategory::where('id', $application->membership_category_id)->first();
        if ($application->old_membership_category_id) {
            $completedApplication        = Application::where('institution_id', $application->institution_id)->where('membership_category_id', $application->old_membership_category_id)->first();
            $completedMembershipCategory = MembershipCategory::where('id', $completedApplication->membership_category_id)->first();
        } else {
            $completedApplication        = Application::where('institution_id', $application->institution_id)->where('application_type_status', Application::typeStatus['ASC'])->first();
            $completedMembershipCategory = MembershipCategory::where('id', $completedApplication->membership_category_id)->first();
        }

        $data = Application::where('applications.id', $completedApplication->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $response = [
            'member_name'                  => $data->company_name,
            'membership_category_name'     => $membershipCategory->name,
            'previous_membership_category' => $completedMembershipCategory->name,
            'disclosure_link'              => route('disclosure_link', request('application_uuid')),
        ];

        return successResponse("Here you go", $response);
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
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Institution has a pending request for this membership category");
        }

        $institution  = Institution::find(auth()->user()->institution_id);
        $old_category = MembershipCategory::find(request('old_category'));
        $new_category = MembershipCategory::find(request('new_category'));
        // $data = Application::where('applications.id', auth()->user()->application[0]->id);
        $data = Application::where('applications.id', $institution->application[0]->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if (! $this->canAddCategory($new_category)) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Institution can not initiate request at this moment");
        }

        $status         = new Status();
        $status->office = Application::office['AP'];
        $status->status = Application::statuses['PEN'];
        $status->save();

        $application = Application::create([
            'institution_id'                => $institution->id,
            'submitted_by'                  => auth()->user()->id,
            'membership_category_id'        => request('new_category'),
            'old_membership_category_id'    => request('old_category'),
            'status'                        => $status->id,
            'office_to_perform_next_action' => Application::office['AP'],
            'application_type'              => Application::type['CON'],
            'application_type_status'       => Application::typeStatus['ASP'],
        ]);

        $application->status()->save($status);

        ApplicationProcessTimestamp::create([
            'application_id' => $application->id,
        ]);

        $Meg                     = Utility::getUsersByCategory(Role::MEG);
        $categoryNameWithPronoun = Utility::categoryNameWithPronoun($old_category->name);

        $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
        $fsd = Utility::getUsersEmailByCategory(Role::FSD);

        $ccs = array_merge($Mbg, $fsd);

        Notification::send($Meg, new InfoNotification(MailContents::megConversionRequestMail($data->company_name, $categoryNameWithPronoun), MailContents::megConversionRequestTitle(), $ccs));

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
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Institution has a pending request for this membership category");
        }

        $new_category = MembershipCategory::find(request('new_category'));

        if (! $this->canAddCategory($new_category)) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Institution can not initiate request at this moment");
        }

        $institution = Institution::find(auth()->user()->institution_id);
        // $data = Application::where('applications.id', auth()->user()->application[0]->id);
        $data = Application::where('applications.id', $institution->application[0]->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $status         = new Status();
        $status->office = Application::office['AP'];
        $status->status = Application::statuses['PEN'];
        $status->save();

        $application = Application::create([
            'institution_id'                => $institution->id,
            'submitted_by'                  => auth()->user()->id,
            'membership_category_id'        => request('new_category'),
            'status'                        => $status->id,
            'office_to_perform_next_action' => Application::office['AP'],
            'application_type'              => Application::type['ADD'],
            'application_type_status'       => Application::typeStatus['ASP'],
        ]);

        ApplicationProcessTimestamp::create([
            'application_id' => $application->id,
        ]);

        $application->status()->save($status);

        $Meg = Utility::getUsersByCategory(Role::MEG);
        $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
        $Fsd = Utility::getUsersEmailByCategory(Role::FSD);

        $ccs = array_merge($Mbg, $Fsd);

        Notification::send($Meg, new InfoNotification(MailContents::megAdditionRequestMail($data->company_name), MailContents::megAdditionRequestTitle(), $ccs));

        logAction(auth()->user()->email, 'Addition Request Sent', "Addition Request Sent {$data->company_name}.", $request->ip());

        return successResponse("You have started the addition process");

    }

    protected function canAddCategory(MembershipCategory $category)
    {
        $rml_rmq_application = Application::where('membership_category_id', MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_LISTINGS_QUOTATIONS'])->where('institution_id', auth()->user()->institution_id)->exists();
        $rmlq_application    = Application::whereIn('membership_category_id', [MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_LISTINGS'], MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_QUOTATIONS']])->where('institution_id', auth()->user()->institution_id)->exists();
        $newCategory         = $category;

        if (($rml_rmq_application &&
            in_array($newCategory->id, [MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_LISTINGS'], MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_QUOTATIONS']]))) {
            return false;
        }

        if (($rmlq_application &&
            in_array($newCategory->id, [MembershipCategory::CATEGORIES['REGISTRATION_MEMBER_LISTINGS_QUOTATIONS']]))) {
            return false;
        }

        return true;
    }
}
