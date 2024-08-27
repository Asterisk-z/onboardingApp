<?php

namespace App\Helpers;

use App\Models\User;

class MailContents
{
    public static function signupMailSubject(): string
    {
        return "Registration Successful";
    }

    public static function signupMail($email, $date, $signature): string
    {
        $url = config("app.front_end_url") . "/set/password?signature=" . $signature . "&email=" . $email;
        $date = formatDate($date);
        return "<p>Your account has been successfully created.</p>
        <p>Your login details are as follows:</p>
        <ul>
            <li><strong>Username:</strong> {$email}</li>
            <li><strong>Account Creation Date:</strong> {$date}</li>
        </ul>
        <p>Kindly click on this <a href=$url>link</a> to proceed.</p>";
    }

    public static function complaintSubmitSubject($name): string
    {
        return "New FMDQX MROIS Complaint {$name}";
    }

    public static function complaintSubmitMail($name, $institution, $body): string
    {
        return "<p>Please be informed that the '{$institution}' has logged a complaint. Kindly see the complaint below :</p>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Institution:</strong> {$institution}</p>
            <p><strong>Body:</strong> {$body}</p>";
    }

    public static function complaintCommentSubject(): string
    {
        return "New Comment on Complaint";
    }

    public static function complaintCommentMail($comment, $status): string
    {
        return "<p>You have a new comment on the complaint you made:</p>
        <ul>
            <li><strong>Status:</strong> {$status}</li>
            <li><strong>Comment:</strong> {$comment}</li>
        </ul>";
    }

    public static function complaintStatusSubject(): string
    {
        return "Complaint Status update";
    }

    public static function complaintStatusMail($status): string
    {
        return "<p>The status of a complaint you logged has just been updated:</p>

        <ul>
            <li><strong>Status:</strong> {$status}</li>
        </ul>";
    }

    public static function newMembershipSignupSubject(): string
    {
        return "New Membership Signup";
    }

    public static function newMembershipSignupMail($name, $category): string
    {
        return "<p>A new applicant, $name, has successfully signed up on the FMDQX MROIS Portal</p>";
    }

    public static function newBroadcastMessageSubject(): string
    {
        return "New Broadcast Message";
    }

    public static function newBroadcastMessage($title, $content, $file = null): string
    {
        return "<p>There is a new message from the MROIS Portal:</p>

        <ul>
            <li><strong>Title:</strong> {$title}</li>
            <p><strong>{$content}</strong></p>
        </ul>";
    }

    public static function newSanctionMessageSubject(): string
    {
        return "New Disciplinary and Sanctions Message";
    }

    public static function newSanctionMessage($ar_name, $ar_summary, $sanction_summary): string
    {
        return "<p>There is a new message from the MROIS Portal:</p>

        <ul>
            <li><strong>AR:</strong> {$ar_name}</li>
            <li>AR Summary: <strong>{$ar_summary}</strong></li>
            <li>Sanction Summary: <strong>{$sanction_summary}</strong></li>
        </ul>";
    }

    public static function newMegSanctionMessageSubject(): string
    {
        return "New Disciplinary & Sanctions Record";
    }

    public static function newMegSanctionMessage($ar_reg, $ar_name): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that the {$ar_reg} Of {$ar_name} has been sanction for an infraction. <br>
        Kindly log on to the <a href=$url>MROIS Portal</a>
                    to view change </p>";
    }

    public static function submitCompetencySubject(): string
    {
        return "Competency Review";
    }

    public static function submitCompetencyMessage(User $arUser): string
    {

        $url = config("app.front_end_url");

        return "<p>Please be informed that the {$arUser->full_name} with
                    {$arUser->reg_id} has updated his competency
                    module. </p>
        <p>Kindly log on to the <a href=$url>MROIS Portal</a>
                    to approve/ decline.</p>";
    }

    public static function arStatusCompetencySubject(): string
    {
        return "Competency Review";
    }

    public static function arStatusCompetencyMessage(User $arUser, $competencyFramework, $status): string
    {
        $url = config("app.front_end_url");

        return "<p>Please be informed that the {$competencyFramework->name}
            has been {$status} by {$arUser->full_name}. </p>
        <p>Kindly log on to the <a href=$url>MROIS Portal</a>
                    to view.</p>";
    }

    public static function megArStatusCompetencySubject(): string
    {
        return "AR Competency Update";
    }

    public static function megArStatusCompetencyMessage(User $arUser, $competencyFramework): string
    {
        $url = config("app.front_end_url");

        return "<p>Please be informed that the {$competencyFramework->name}
            was updated by {$arUser->full_name}. </p>
        <p>Kindly log on to the <a href=$url>MROIS Portal</a>
                    to view.</p>";
    }

    public static function megStatusCompetencySubject(): string
    {
        return "Competency Review";
    }

    public static function megStatusCompetencyMessage($message, $competencyFramework, User $arUser): string
    {
        $url = config("app.front_end_url");

        return "<p>Please be informed that the {$competencyFramework->name} upload by {$arUser->full_name}
            has the below deficiency.</p>
            <p>{$message}</p>
        <p>Kindly log on to the <a href=$url>MROIS Portal</a>
                    to reload and approve.</p>";
    }

    public static function invoiceSubject(): string
    {
        return "MROIS Membership Payment Notification";
    }

    public static function invoiceMail(): string
    {
        $url = config("app.front_end_url");

        return "<p>Kindly log on to the <a href=$url>MROIS Portal</a> to view your invoice,
        make payment and upload evidence of payment (if applicable) to complete your registration.</p>";
    }

    public static function concessionSubject(): string
    {
        return "New Membership Application: Concession Confirmation";
    }

    public static function concessionMail($companyName): string
    {
        return "<p>A new applicant, {$companyName}, has been granted a concession.</p>";
    }

    public static function megConversionRequestTitle(): string
    {
        return "New Membership Conversion Application";
    }

    public static function megConversionRequestMail($company_name, $membership_category): string
    {
        $url = config("app.front_end_url");

        return "<p>Please be informed that {$company_name} {$membership_category} has initiated a Membership Conversion.</p>";
    }

    public static function megAdditionRequestTitle(): string
    {
        return "New Membership Addition Application";
    }

    public static function megAdditionRequestMail($company_name): string
    {
        $url = config("app.front_end_url");

        return "<p>Please be informed that {$company_name} has initiated Membership Addition</p>";
    }
    public static function paymentSubject(): string
    {
        return "Membership Application Payment Notification";
    }

    public static function paymentMail($user): string
    {
        $url = config("app.front_end_url");

        return "<p>Kindly log on to the <a href=$url>MROIS Portal</a> to
        review the payment upload information for the Applicant, {$user->first_name} {$user->last_name}.</p>";
    }

    public static function approvedPaymentSubject(): string
    {
        return "Payment Confirmation by FSD";
    }

    public static function approvedPaymentMail($user): string
    {
        $url = config("app.front_end_url");

        return "<p>FSD has confirmed payment for {$user->first_name} {$user->last_name}.

        <p>Kindly log on to the <a href=$url>MROIS Portal</a> to
        review and approve payment</p>

        </p>";
    }

    public static function mbgPaymentRejectedSubject(): string
    {
        return "Payment Rejected by MBG";
    }

    public static function mbgPaymentRejectedMail($companyName, $reason): string
    {
        return "<p>Please be informed that MBG rejected the FSD review for {$companyName}
                <p>Reason: {$reason}</p>

                </p>";
    }

    public static function mbgPaymentApprovedSubject(): string
    {
        return "Membership Application Payment Verified by MBG";
    }

    public static function mbgPaymentApprovedMail($companyName): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that MBG has confirmed payment for
        {$companyName}. Kindly log on to <a href=$url>MROIS Portal</a> to review the application.</p>";
    }

    public static function megReportValidationSubject(): string
    {
        return "MEG Report Validation";
    }

    public static function meg2EsuccessSubject(): string
    {
        return "E-success letter generated successfully";
    }

    public static function meg2EsuccessMail($companyName): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed E-Success letter has been generated for
        {$companyName}. Kindly log on to <a href=$url>MROIS Portal</a> to approve the application report.</p>";
    }

    public static function megReportValidationMail($companyName): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that MEG has uploaded the Application Report for
        {$companyName}. Kindly log on to <a href=$url>MROIS Portal</a> to approve the application report.</p>";
    }

    public static function memberAgreementSubject(): string
    {
        return "Membership Agreement";
    }

    public static function memberAgreementMail($applicant): string
    {
        $url = config("app.front_end_url");
        return "<p>Kindly login to the <a href=$url>MROIS Portal</a> to view the latest update concerning agreement review.</p>";
    }

    public static function meG2ApprovalSubject(): string
    {
        return "Application Report Update";
    }

    public static function meG2ApprovalMail($companyName, $categoryName): string
    {
        $url = config("app.front_end_url");
        return "<p>Kindly be informed that {$companyName} Application Report for {$categoryName} Categories has been approved.</p>
        <p>Kindly log on to <a href=$url>MROIS Portal</a> to proceed with the Application.</p>";
    }

    public static function applicantUploadAgreementSubject(): string
    {
        return "MROIS Agreement Upload Notification";
    }

    public static function applicantUploadAgreementMail($name): string
    {
        $url = config("app.front_end_url");

        return "<p>{$name}, has updated its application with the executed Membership Agreement.</p>

        <p>Kindly log on to the <a href=$url>MROIS Portal</a> to review and execute the Agreement.</p>";
    }

    public static function ApplicantArUpdateSubject(): string
    {
        return "Update Authorised Representatives";
    }

    public static function ApplicantArUpdateMail($categoryName): string
    {
        $url = config("app.front_end_url");

        return "<p>Kindly log on to the <a href=$url>MROIS Portal</a> to update your Institution's
        Authorised Representatives to complete the {$categoryName} application process.";
    }

    public static function SuccessfulApplicationSubject(): string
    {
        return "Application Successful";
    }

    public static function SuccessfulApplicationMail($categoryName): string
    {
        $url = config("app.front_end_url");

        return "<p>We are pleased to inform you that your application for the {$categoryName}
        category of FMDQ Securities Exchange Limited is successful.</p>

        <p>Kindly log on to the <a href=$url>MROIS Portal</a> to view your completed application.</p>";
    }

    public static function msgProfilingSubject($categoryName): string
    {
        return "Profiling Request:$categoryName";
    }

    public static function msgProfilingMail($categoryName): string
    {
        return "<p>Please be informed that the Institution outlined below has fulfilled the registration requirements to become
                an FMDQ Exchange {$categoryName} and is entitled to have access to the e-Markets portal:
                Kindly profile the Institution and confirm upon completion.</p>";
    }

    public static function helpdeskupdateSubject($categoryName): string
    {
        return "Update of {$categoryName} Register";
    }

    public static function helpdeskupdateMail($companyName, $categoryName): string
    {
        $url = "https://fmdqgroup.com/exchange/Membership/";
        return "<p>Kindly add $companyName to the $categoryName Register on FMDQ Exchange Website.
                The page link is as stated below:</p>
        <p><a href=$url>https://fmdqgroup.com/exchange/Membership/</a></p>";
    }

    public static function helpdeskMailingSubject($categoryName): string
    {
        return "Email Group Update for {$categoryName}";
    }

    public static function helpdeskMailingMail(): string
    {
        return "<p>Kindly update the mailing group with the details below:</p>";
    }

    public static function documentReuploadSubject(): string
    {
        return "MROIS Document Upload";
    }

    public static function documentReuploadMail($apllicantName): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that {$apllicantName} has resubmitted documents on the MROIS Portal.</p>
        <p>Kindly log on to the <a href=$url>MROIS Portal</a> to proceed with the application.</p>";
    }

    public static function profileArSystemSubject($system): string
    {
        return "Authorised Representative Profiling on the {$system}";
    }

    public static function profileArSystemMail($name, $system): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that $name has requested
        the creation of some ARs profile on the $system.
        Kindly log on to the <a href=$url>MROIS Portal</a> to approve or reject the request";
    }

    public static function mbgApproveProfileArSystemMail($system): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that MBG has requested
        the creation of some ARs profile on the $system.
        Kindly log on to the <a href=$url>MROIS Portal</a> to create profile";
    }

    public static function arNotificationOfChangeSubject($request_id, $subject): string
    {
        return "New FMDQX MROIS Notification of Change {$request_id}:{$subject}";
    }

    public static function arNotificationOfChangeMail(User $user, $request_id): string
    {
        $url = config("app.front_end_url");
        $ar_id = $user->getRegID();
        return "<p>Please be informed that a notification of change has been
        made by an AR of your Institution with AR ID `$ar_id`.
        Kindly login to the <a href=$url>MROIS Portal</a>  to approve the
        request $request_id.";
    }

    public static function megNotificationOfChangeSubject(): string
    {
        return "MROIS Notification of Change";
    }

    public static function megNotificationOfChangeMail(User $user): string
    {
        $url = config("app.front_end_url");
        $ar_id = $user->getRegID();
        $memberName = $user->full_name;
        return "<p>Please be informed that a notification of change has been made
        by the`$ar_id` of '$memberName'.
        Kindly login to the <a href=$url>MROIS Portal</a>  to view change.";
    }

    public static function notificationOfChangeNewCommentSubject(): string
    {
        return "MROIS Notification of Change New Comment";
    }

    public static function notificationOfChangeNewCommentMail(): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that a comment was made on a notification of change.
        Kindly login to the <a href=$url>MROIS Portal</a>  to view.";
    }

    public static function arNotificationOfChangeAcceptSubject($request_id, $subject): string
    {
        return "New FMDQX MROIS Notification of Change {$request_id}:{$subject}";
    }

    public static function arNotificationOfChangeAcceptMail($request_id): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that the notification of change `$request_id`.
        has been accepted. Kindly login to the  <a href=$url>MROIS Portal</a>  to view.";
    }

    public static function arNotificationOfChangeRejectSubject($request_id, $subject): string
    {
        return "New FMDQX MROIS Notification of Change {$request_id}:{$subject}";
    }

    public static function arNotificationOfChangeRejectMail($request_id, $reason): string
    {
        $url = config("app.front_end_url");
        return "<p>Please be informed that the notification of change  `$request_id`.
        has been rejected.
        <br>
        Reason: $reason ";
    }

    public static function newStakeHolderRequestSubject(): string
    {
        return "Internal Stakeholder Request";
    }

    public static function newStakeHolderRequestMail($email): string
    {
        $url = config("app.front_end_url");
        return "<p>A stakeholder with mail $email sent a request to view report.
     Kindly login to the  <a href=$url>MROIS Portal</a>  to allow or decline.</p>";
    }
}
