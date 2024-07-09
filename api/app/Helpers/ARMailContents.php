<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Str;

class ARMailContents
{
    public static function approvedARSubject(): string
    {
        return "Authorised Representative Application";
    }

    public static function approvedARBody(User $ARUser, string $password): string
    {

        $signature = Str::random(100);
        $link = config("app.front_end_url") . "/auth-password-reset?token=" . $signature . "&email=" . $ARUser->email;

        $company = $ARUser->institution->name ?? "undefined";
        $regID = $ARUser->getRegID();

        return "<p>
                Please be informed that you have been selected as an Authorised Representative for $company.
                </p>

            <p>
                Your FMDQ unique identification number is <b>$regID</b> and your login details for the MROIS Portal is given below:
                <br>
                Username: $ARUser->email <br>
                Password: $password
            </p>

            <p>
                Click the link to <a href=" . $link . ">reset</a> the password
            </p>

            <p>
                Please note that your ID would be required in future correspondence with FMDQ. We advise that you keep it safely.
            </p>";
    }

    public static function applicationMEGSubject(): string
    {
        return "New Authorised Representative";
    }

    public static function applicationMEGBody(User $ARUser): string
    {
        $link = env("APP_FRONTEND_URL");
        $company = $ARUser->institution->name ?? "Undefined";
        $message = "<p>
                    Please be informed that $company has added a new Authorised Representative.
                </p>
                <br>
                <p>
                    Kindly login to the <a href='" . $link . "'>MROIS Portal</a> to approve or reject
                </p>
                <br>";

        return $message;
    }

    public static function transferAuthoriserSubject(): string
    {
        return "Authorised Representative Transfer";
    }

    public static function transferAuthoriserBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        $lastName = $ARUser->last_name;
        $firstName = $ARUser->first_name;
        return "<p>
            Kindly login to the “MROIS Portal” to approve the transfer of <b>$lastName $firstName</b>  With AR ID <b>$regID</b>
        </p>";
    }

    public static function changeStatusAuthoriserSubject(string $action): string
    {
        return "Authorised Representative $action";
    }

    public static function changeStatusAuthoriserBody(User $ARUser, string $action): string
    {
        $regID = $ARUser->getRegID();
        return "<p>
            Kindly login to the “MROIS Portal” to approve/reject the <b>$action</b> of <b>$regID</b>
        </p>";
    }

    public static function updateAuthoriserSubject(): string
    {
        return "Authorised Representative Update";
    }

    public static function updateAuthoriserBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        return "<p>
            Kindly login to the “MROIS Portal” to approve/reject the <b>Update</b> of <b>$regID</b>
        </p>
        ";
    }

    public static function updatedMEGSubject(): string
    {
        return "Authorised Representative Update";
    }

    public static function updatedMEGBody(User $oldUserDetails, array $updateFields): string
    {

        $basicData = $oldUserDetails->getBasicData(true);
        $basicDataStr = prettifyJson($basicData);
        $updateFieldsStr = prettifyJson($updateFields);
        return "<p>
            This is to inform you of an AR update:
        </p>

        <p>
            Record: <br>        </p>

                          <table className='table table-striped table-bordered table-hover' style='padding: 10px; text-align: left;'>
                              <thead>
                                  <tr>
                                      <th scope='col'></th>
                                      <th scope='col'>Old Record</th>
                                      <th scope='col'>Updated Record</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td  style='padding: 5px;'>First Name</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['firstName'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['first_name'] . "</td>
                                  </tr>
                                  <tr>
                                      <td  style='padding: 5px;'>Last Name</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['lastName'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['last_name'] . "</td>
                                  </tr>
                                  <tr>
                                      <td  style='padding: 5px;'>Middle Name</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['middleName'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['middle_name'] . "</td>
                                  </tr>
                                  <tr>
                                      <td  style='padding: 5px;'>Email</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['email'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['email'] . "</td>
                                  </tr>
                                  <tr>
                                      <td  style='padding: 5px;'>Phone</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['phone'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['phone'] . "</td>
                                  </tr>
                                  <tr>
                                      <td  style='padding: 5px;'>Role</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $basicData['role'] . "</td>
                                      <td  style='padding: 5px;' className='text-capitalize'>" . $updateFields['role']['name'] . "</td>
                                  </tr>
                              </tbody>
                          </table>
        ";
    }

    public static function deactivationMEGSubject(): string
    {
        return "Authorised Representative Deactivation";
    }

    public static function deactivationMEGBody(User $ARUser): string
    {
        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that an Authorised Representative for $company has been deactivated.
            </p>

            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID <br>
                Status: <b>Deactivated</b>
            </p>";

        return $message;
    }

    public static function activationMEGSubject(): string
    {
        return "Authorised Representative Re-activated";
    }

    public static function activationMEGBody(User $ARUser): string
    {

        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        $message = "<p>Please be informed that an Authorised Representative for $company has been re-activated.</p>
            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID <br>
                Status: <b>Activated</b>
            </p>";

        return $message;
    }

    public static function transferDeclineRequesterSubject(): string
    {
        return "Authorised Representative Transfer Declined";
    }

    public static function transferDeclineRequesterBody(User $ARUser, $reason): string
    {
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that the transfer of AR $regID was declined.
            </p>

            <p>
                Reason: $reason
            </p>";

        return $message;
    }

    public static function transferApprovedMEGSubject(): string
    {
        return "Authorised Representative Transfer";
    }

    public static function transferApprovedMEGBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();

        $message = "<p>
                Kindly login to the “MROIS Portal” to approve a transferred Authorised Representative with AR ID $regID
            </p>";

        return $message;
    }
}
