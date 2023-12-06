<?php 

return [
    'otp_type' => env('OTP_TYPE', 'numeric'),
    'otp_lenght' => env('OTP_LENGTH', 4),
    'app_id' => env('OTP_APP_ID',101),
    'username' => env('OTP_USERNAME','rrs'),
    'password' => env('OTP_PASSWORD',11111),
    'url' => env('OTP_URL','https://adgtest.fmdqgroup.com/otp/api/master')
];