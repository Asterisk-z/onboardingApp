<?php

namespace App\Helpers;

use App\Models\Application;
use App\Models\MemberAgreement;
use Illuminate\Support\Facades\Storage;
use PDF;

class EMemberAgreement
{
    protected $name = null;
    protected $grade = null;
    protected $division = null;
    protected $signature = null;
    protected $regId = null;

    public function generate(Application $application)
    {

        $membershipCategory = $application->membershipCategory;

        if (!$details = MemberAgreement::where('application_id', $application->id)->first()) {
            return "error";
        }

        $pdf = PDF::loadView('agreement.' . $membershipCategory->code, compact('details'));
        Storage::put('public/agreement/e_membership_agreement' . $application->id . '.pdf', $pdf->output());
        $application->membership_agreement = 'agreement/e_membership_agreement' . $application->id . '.pdf';
        $application->save();
        return true;

    }

}
