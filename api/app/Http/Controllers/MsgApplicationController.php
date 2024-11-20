<?php

namespace App\Http\Controllers;

use App\Models\ArCreationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MsgApplicationController extends Controller
{
    public function arCreationRequest(Request $request)
    {
        $ar_creation_request = ArCreationRequest::orderBy('created_at', 'DESC')->get();
        return successResponse("Here you go", $ar_creation_request);
    }

    public function reviewArSystemCreationRequest(Request $request)
    {
        $request->validate([
            'status' => 'required|in:treated,rejected',
            'ar_request_id' => 'required|exists:ar_creation_requests,id',
        ]);

        $ar_creation_request = ArCreationRequest::find($request->ar_request_id);

        if ($ar_creation_request->next_office != 'MSG' && $ar_creation_request->msg_status != 'Pending') {
            errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "You are not permitted to perform this action at this time");
        }

        $user = $request->user();

        switch ($request->status) {
            case 'treated':
                $ar_creation_request->msg_status = ucfirst($request->status);
                $ar_creation_request->status = 'Treated';
                $ar_creation_request->save();

                logAction($user->email, 'AR CREATION REQUEST', "AR creation request on FMDQ system was treated by MSG", $request->ip());
                break;

            case 'rejected':
                $ar_creation_request->msg_status = ucfirst($request->status);
                $ar_creation_request->status = ucfirst($request->status);
                $ar_creation_request->save();

                logAction($user->email, 'AR CREATION REQUEST', "AR creation request on FMDQ system was rejected by MSG", $request->ip());

                break;

            default:
                # code...
                break;
        }

        return successResponse("Request status updated successfully");
    }
}
