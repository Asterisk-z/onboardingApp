<?php
namespace App\Helpers;

class MailContents
{
    public static function signupMailSubject() : string {
        return "Registration Successful";
    }
    public static function signupMail($email, $date) : string {
        return "<p>Your account has been successfully created. Below are your login details:</p>

        <ul>
            <li><strong>Username:</strong> {$email}</li>
            <li><strong>Account Creation Date:</strong> {$date}</li>
        </ul>
        
        <p>Kindly click on this <a href='".config('app.url')."'>link</a> to proceed.</p>";
    }

}