<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    // Send OTP to a phone number
    public function sendOTP($phoneNumber)
    {
        $response = $this->client->verify->v2->services(env('TWILIO_VERIFY_SID'))
            ->verifications
            ->create($phoneNumber, "sms");

        return $response;
    }

    // Verify OTP for a phone number
    public function verifyOTP($phoneNumber, $code)
    {
        $response = $this->client->verify->v2->services(env('TWILIO_VERIFY_SID'))
            ->verificationChecks
            ->create([
                "to" => $phoneNumber,
                "code" => $code
            ]);

        return $response->status === "approved";
    }
}
