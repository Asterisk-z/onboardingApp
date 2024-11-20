<?php

namespace App\Helpers;

use App\Models\Application;

class DisclosureLetter
{
    protected $name = null;
    protected $grade = null;
    protected $division = null;
    protected $signature = null;
    protected $regId = null;
    protected $designation = null;
    protected $address = null;
    protected $companyName = null;
    protected $application = null;
    protected $main_application = null;

    public function generate(Application $application, $preview = false)
    {
        $content = null;

        if ($application->application_type == Application::type['ADD']) {
            if (!$main_application = Application::where('institution_id', $application->institution_id)->where('application_type_status', Application::typeStatus['ASC'])->first()) {
                return $content;
            }
        }

        if ($application->application_type == Application::type["CON"]) {
            if (!$main_application = Application::where('institution_id', $application->institution_id)->where('application_type_status', Application::typeStatus['ASC'])->where('membership_category_id', $application->old_membership_category_id)->first()) {
                return $content;
            }
        }

        if (!$main_application) {
            return $content;
        }

        $this->application = $application;
        $this->main_application = $main_application;

        $data = Application::where('applications.id', $main_application->id);
        $main_application_data = Utility::applicationDetails($data);
        $main_application_data = $main_application_data->first();

        $content = $this->dmbWithSECLicenseLetterContent($main_application_data);

        return $content;

    }

    protected function dmbWithSECLicenseLetterContent($application)
    {

        $date = now();

        $membershipCategory = $this->application->membershipCategory->name;
        $mainCompanyName = $application->companyName;
        $mainMembershipCategory = $this->main_application->membershipCategory->name;

        return [
            'body' => "<p><b>$date</b></p>
                            <p>DECLARATION OF PRIOR DISCLOSURE – $mainCompanyName </p>
                            <p>With reference to $mainCompanyName ’s application for membership in the FMDQ Securities Exchange Limited (“FMDQ Exchange” or the “Exchange”) $membershipCategory membership category, we declare as follows: </p>
                            <p>
                                <ol>
                                    <li>The required documents/disclosures for onboarding as a $mainMembershipCategory have previously been provided to the Exchange.</li><br/>
                                    <li>The referenced documents/disclosures remain valid and subsisting and no amendment/alteration or material change has occurred, and no amendment has been made to the document(s) previously filed with and/or disclosure(s) made to the Exchange.</li><br/>
                                    <li>Where there is an amendment/alteration or material change in the documents/disclosures provided above, we shall upload the valid and subsisting documentation when completing the Application Form. </li><br/>
                                </ol>
                            </p>
                            <p style='margin-top: 10px;'>
                                Yours faithfully, <br />
                                <b>FOR: $mainCompanyName</b>
                            </p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p>_______________________ <br>Authorised Signatory</p>
                            ",
        ];
    }

}
