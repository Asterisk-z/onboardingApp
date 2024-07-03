<?php

namespace App\Http\Controllers;

use App\Jobs\SendSuccessfulPayment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class QpayController extends Controller
{

    public function success(Request $request)
    {
        logger($request->all());

        $validator = Validator::make($request->all(), [
            // "newRef" => "required|exists:invoices,reference",
            "newRef" => "required",
            "newStatus" => "required|in:successful,failed",
        ]);

        if ($validator->fails()) {
            logger($validator->errors());
            return response()->json([
                "message" => "We are unable to process your payment at this moment.",
                "data" => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $ref = $request->newRef;

        logger($ref);

        $refArr = explode('_', $ref);
        $reference = $refArr[1];

        if (!$invoice = Invoice::where('reference', $reference)->first()) {
            logger("Invalid Reference: $request->newRef");

            return response()->json([
                "message" => "We are unable to process your payment at this moment.",
            ], Response::HTTP_BAD_REQUEST);
        }

        if (strtolower($request->newStatus) != 'successful') {
            logger("Invalid Status: Status should be success, {$request->newStatus} was returned.");

            return response()->json([
                "message" => "We are unable to process your payment at this moment.",
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($invoice->is_paid) {
            logger("Payment has already been made for this Reference: {$request->newStatus}");

            return response()->json([
                "message" => "We are unable to process your payment at this moment.",
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['newRef'] = $reference;

        SendSuccessfulPayment::dispatch($data, $request->ip());

        return redirect(config('app.front_end_url') . '/qpay_check?status=success');

        // return response()->json([
        //     "message" => "Payment has been processed and under review",
        // ]);

    }

    public function fail(Request $request)
    {
        logger($request->all());

        return redirect(config('app.front_end_url') . '/qpay_check?status=failed');
        // return response()->json([
        //     "message" => "Done",
        // ]);
    }

}
