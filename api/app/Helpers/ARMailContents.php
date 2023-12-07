<?php
namespace App\Helpers;

use App\Models\User;

class ARMailContents
{
    public static function approvedARSubject(): string
    {
        return "Authorised Representative Application";
    }

    public static function approvedARBody(User $ARUser, string $password): string
    {
        //TODO: add password change link

        $link = env("APP_FRONTEND_URL");

        if ($link) {
            $link = $link . '?email=' . $ARUser->email;
        }

        $name = $ARUser->first_name . " " . $ARUser->last_name;
        $company = $ARUser->institution->name;
        $regID = $ARUser->getRegID();

        return "<p>Dear $name,</p>
            <p>
                Please be informed that you have been selected as an Authorised Representative for the  $company.
            </p>
            
            <p>
                Your FMDQ unique identification number is <b>$regID</b> and your login details for the MROIS portal is given below:
                <br>
                Username: $ARUser->email <br>
                Password: $password 
            </p>
            
            <p>
                Click <a href='$link'>this link</a> to reset the password.  
            </p>
            
            <p>
                Please not that your ID would be required in future correspondence with FMDQ. We advise that you keep it safely.
            </p>
            <p>
                Regards,<br>
                FMDQ Securities Exchange
            </p>";
    }

    public static function applicationMEGSubject(): string
    {
        return "Authorised Representative Application";
    }

    public static function applicationMEGBody(User $ARUser): string
    {

        $link = env("APP_FRONTEND_URL");

        $company = $ARUser->institution->name;
        $regID = $ARUser->getRegID();



        $message = "<p>Dear MEG,</p>
            <p>
                Please be informed that there is a new Authorised Representative for the  $company.
            </p>
            
            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID 
            </p>
            
            <p>
                Click <a href='$link'>this link</a> to login to the MROIS portal and approve/reject this application. 
            </p>

            <p>
                Regards,<br>
                FMDQ Securities Exchange
            </p>
            ";

        return $message;
    }



    public static function transferAuthoriserSubject(): string
    {
        return "Authorised Representative Transfer";
    }

    public static function transferAuthoriserBody(User $authorizerUser, User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        $name = $authorizerUser->getFullName();
        return "
        <p>
            Dear $name,
        </p>
        <p>
            Kindly login to the “MROIS portal” to approve the transfer of <b>$regID</b>
        </p>
        ";
    }

    public static function changeStatusAuthoriserSubject(string $action): string
    {
        return "Authorised Representative $action";
    }

    public static function changeStatusAuthoriserBody(User $authorizerUser, User $ARUser, string $action): string
    {
        $regID = $ARUser->getRegID();
        $name = $authorizerUser->getFullName();
        return "
        <p>
            Dear $name,
        </p>
        <p>
            Kindly login to the “MROIS portal” to approve/reject the <b>$action</b> of <b>$regID</b>
        </p>
        ";
    }

    public static function updateAuthoriserSubject(): string
    {
        return "Authorised Representative Update";
    }

    public static function updateAuthoriserBody(User $authorizerUser, User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        $name = $authorizerUser->getFullName();
        return "
        <p>
            Dear $name,
        </p>
        <p>
            Kindly login to the “MROIS portal” to approve/reject the <bUpdate</b> of <b>$regID</b>
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
        return "
        <p>
            Dear MEG,
        </p>
        <p>
            This is to inform you of an AR update:
        </p>

        <p>
            Old record: <br>
            $basicDataStr
        </p>

        <p>
                Updated Fields: <br>
                $updateFieldsStr
        </p>
        ";
    }
}