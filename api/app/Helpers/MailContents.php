<?php

namespace App\Helpers;

class MailContents
{
    public static function signupMailSubject(): string
    {
        return "Registration Successful";
    }

    public static function signupMail($email, $date, $signature): string
    {
        $url = config("app.front_end_url")."/set/password?signature=".$signature."&email=".$email;
        $date = formatDate($date);
        return "<p>Your account has been successfully created.</p>
        <p>Your login details are as follows:</p>
        <ul>
            <li><strong>Username:</strong> {$email}</li>
            <li><strong>Account Creation Date:</strong> {$date}</li>
        </ul>
        <p>Kindly click on this <a href=$url>link</a> to proceed.</p>";
    }

    public static function complaintSubmitSubject(): string
    {
        return "New Complaint Logged";
    }

    public static function complaintSubmitMail($name, $institution, $body): string
    {
        return "<p>You have a new complaint, details below:</p>

        <ul>
            <li><strong>Name:</strong> {$name}</li>
            <li><strong>Institution:</strong> {$institution}</li>
            <li><strong>Body:</strong> {$body}</li>
        </ul>";
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
        return "<p>A new applicant, $name, has successfully signed up on the MROIS portal</p>";
    }

    public static function newBroadcastMessageSubject(): string
    {
        return "New Broadcast Message";
    }

    public static function newBroadcastMessage($title, $content, $file = null): string
    {
        return "<p>There is a new message from the MROIS portal:</p>

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
        return "<p>There is a new message from the MROIS portal:</p>

        <ul>
            <li><strong>AR:</strong> {$ar_name}</li>
            <li>AR Summary<strong>{$ar_summary}</strong></li>
            <li>Sanction Summary<strong>{$sanction_summary}</strong></li>
        </ul>";
    }

    public static function submitCompetencySubject(): string
    {
        return "Competency Submitted";
    }

    public static function submitCompetencyMessage(): string
    {
        return "<p>A new competency has been submitted.</p>";
    }

    public static function rejectedCompetencySubject(): string
    {
        return "Competency Response Rejected";
    }

    public static function rejectedCompetencyMessage($reason): string
    {
        return "<p>A new competency has been submitted.</p><p>Reason: {$reason}.</p>";
    }

    public static function invoiceSubject(): string
    {
        return "MROIS Membership Payment Notification";
    }

    public static function invoiceMail(): string
    {
        $url = config("app.front_end_url");

        return "<p>Kindly log on to the <a href=$url>MROIS Portal</a> to view your invoice,
        make payment and upload evidence of payment to complete your registration.</p>";
    }

    public static function concessionSubject(): string
    {
        return "New Membership Application: Concession Confirmation";
    }

    public static function concessionMail($companyName): string
    {
        return "<p>A new institution, {$companyName}, has been granted a concession.</p>";
    }

    public static function paymentSubject(): string
    {
        return "Payment Notification";
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
        return "Payment Verified by MBG";
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

    public static function memberAgreementMail(): string
    {
        $url = config("app.front_end_url");
        return "<p>Kindly log on to <a href=$url>MROIS Portal</a> to view the latest update concerning Agreement Review.</p>";
    }

    public static function meG2ApprovalSubject(): string
    {
        return "Application Report Update";
    }

    public static function meG2ApprovalMail($companyName, $categoryName): string
    {
        $url = config("app.front_end_url");
        return "<p>Kindly be informed that {$companyName} Application Report for {$categoryName} Category has been approved.</p>
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
        
        <p>Kindly log on to the <a href=$url>MROIS Portal</a> to review application.</p>";
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
}
