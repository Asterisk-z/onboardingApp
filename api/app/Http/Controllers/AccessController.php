<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\StakeHolderAccessRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AccessController extends Controller
{

    public function getAllRequest(Request $request)
    {
        $data = StakeHolderAccessRequest::latest()->get();
        return successResponse("Here you go", $data);
    }

    public function actionRequest(Request $request)
    {
        $request->validate([
            'holder_id' => 'required',
            'status' => 'required|in:approved,declined',
        ]);

        if (!$access = StakeHolderAccessRequest::where('id', request('holder_id'))->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Request Not Found');
        }

        $access->status = request('status');
        $access->save();

        if (request('status') == StakeHolderAccessRequest::APPROVED) {

            $user = User::firstOrCreate(['email' => $access->email], User::STAKEHOLDER_DATA($access->email));
            $user->approval_status = 'approved';
            $user->save();
            logAction($user->email, 'Stake holder access status updated', "Access Request.", $request->ip());
        }

        return successResponse("Access Status Updated Successfully", []);

    }
}
