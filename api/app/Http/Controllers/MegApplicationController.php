<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Invoice;
use App\Models\ProofOfPayment;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Traits\ApplicationTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class MegApplicationController extends Controller
{
    use ApplicationTraits;
    /**
     * get institutions that are due for FSD review
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function institutions(Request $request)
    {
        $data = Application::where([
            'concession_stage'  => true,
            'office_to_perform_next_action' => Application::office['MEG']
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();


        return successResponse("Here you go", ApplicationResource::collection($data));
    }
}
