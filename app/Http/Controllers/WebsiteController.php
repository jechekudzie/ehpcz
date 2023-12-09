<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Kapouet\Notyf\Facades\Notyf;

class WebsiteController extends Controller
{
    public function emailContactForm(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'name'                  => 'required',
                'surname'                  => 'required',
                'email'                 => 'required|email',
                'subject'                 => 'required',
                'message'              => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $mail = array(
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'web' => $request->input('web'),
            'message' => $request->input('message'));

        try {
            Mail::to('info@ehpcz.co.zw')
                ->send(new ContactForm($mail));

        } catch (\Exception $exception){
            Log::error($exception);
            Notyf::error('Failed to send the email.');
        }
        Notyf::success('Email sent successfully');
        return redirect()->back();
    }
}
