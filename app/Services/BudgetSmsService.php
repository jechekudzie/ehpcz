<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BudgetSmsService
{
    protected $username;
    protected $userid;
    protected $handle;
    protected $originator;
    protected $url;

    public function __construct()
    {
        $this->username = env('BUDGETSMS_USERNAME');
        $this->userid = env('BUDGETSMS_USERID');
        $this->handle = env('BUDGETSMS_HANDLE');
        $this->originator = env('BUDGETSMS_ORIGINATOR');
        $this->url = env('BUDGETSMS_URL', 'https://api.budgetsms.net/sendsms/');
    }

    public function sendOtp($recipient, $otp)
    {
        $message = "Your OTP code is: {$otp}";

        $response = Http::get($this->url, [
            'username' => $this->username,
            'userid'   => $this->userid,
            'handle'   => $this->handle,
            'msg'      => $message,
            'from'     => $this->originator,
            'to'       => $recipient,
            'customid' => uniqid(), // Optional: Unique identifier for the message
            'price'    => 1,        // Optional: Get price info in the response
            'mccmnc'   => 1,        // Optional: Get operator info in the response
            'credit'   => 1         // Optional: Get account credit info
        ]);

        $responseBody = $response->body();

        // Check the API response for success or failure
        if ($response->successful() && strpos($responseBody, 'OK') !== false) {
            return true;
        }

        return false;
    }
}
