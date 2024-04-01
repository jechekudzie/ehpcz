<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PractitionerProfession;
use App\Models\Qualification;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function verifyAccount()
    {
        $account = PractitionerProfession::where('registration_number', request('field4'))->first();

        if ($account) {
            $accountName = $account->practitioner->first_name.' '.$account->practitioner->last_name;
            $profession = $account->profession->name;
            // Account exists
            return response()->json([
                'message' => 'Account found proceed with payment',
                'data' => [
                    'field1' => '200',
                    'field2' => "Registration number {$account->registration_number} is valid for {$accountName} as a(n) {$profession}.",
                    'field3' => 'merchant_query_001',//reference code
                    'field4' => 'ACTIVE',
                    'field5' => $account->registration_number,
                    'field8' => 'ecocashzw',
                    'field12' => '54.67',
                    'field15' => "{$accountName}",
                    'field17' => 'USSD'
                ]
            ]);
        } else {
            // Account does not exist
            return response()->json([
                'message' => 'Account not found, please confirm account and try again',
                'data' => [
                    'field1' => '404',
                    'field2' => "Account number does not exist",
                    'field3' => 'merchant_query_error',
                    'field4' => 'INACTIVE', // Indicating the account is not active or doesn't exist
                    'field5' => request('field4'), // Reflecting back the submitted account number
                    'field8' => 'ecocashzw', // Maintaining the application code
                    'field12' => '0.00', // Indicating no amount associated with a non-existing account
                    'field15' => 'N/A', // Indicating no account holder's name is available
                    'field17' => 'N/A' // Indicating no payment channel is applicable
                ]
            ]);
        }
    }



    //get all cities
    public function index($province_id)
    {
        $cities = City::where('province_id', $province_id)->get()->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    public function qualifications($profession_id)
    {
        $qualifications = Qualification::where('profession_id', $profession_id)->get()->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'qualifications' => $qualifications
        ]);
    }

}
