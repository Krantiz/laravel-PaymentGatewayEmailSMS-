<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use AWS;
use Mail;
use App\User;
use Auth;
use Log;

class HomeController extends Controller
{

    public $visitNumber = 0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $verified = Auth::user()->verified;
        $verified_email = Auth::user()->verified_email;
        return view('home')->with('verified',$verified)->with('verified_email',$verified_email);
    }


    /**
     * Send Notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotifications()
    {
        try{
            $email_id = Auth::user()->email; 
            $phone_number = Auth::user()->mobile_number;
            $verification_code = rand(10000,99999);
            //Sending SMS using AWS SNS
            $sms = AWS::createClient('sns');
            $formatingNumber = '+91'.$phone_number;

            DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['verify_column' => $verification_code]);

            $sms->publish([
                    'Message' => 'Hey! Enter the below code to Verify - '.$verification_code,
                    'PhoneNumber' => $formatingNumber,    
                    'MessageAttributes' => [
                        'AWS.SNS.SMS.SMSType'  => [
                            'DataType'    => 'String',
                            'StringValue' => 'Transactional',
                         ]
                     ],
                  ]);


            return redirect('home')->with('status', 'OTP has been Sent to registered mobile number');

          } catch (\Exception $e) {

            return view('home')->withErrors(['notSave' => $e->getMessage()]);

        }


    }


    /**
     * Send Notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmailNotifications()
    {
        try{
            $email_id = Auth::user()->email; 
            $phone_number = Auth::user()->mobile_number;
            $verification_code = rand(10000,99999);
            // dd($email_id);
            DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['verify_column' => $verification_code]);

            // Sending Email using AWS SES
            //Email will be sent to only verified email ids as it is under free plan.
            $user = 'Hey! Enter the below code to Verify - '.$verification_code;
            Mail::send('email', ['user' => $user], function ($m) use ($user) {
                $m->from('kranti.gajula@gmail.com', 'Your Application');
                $m->to('kranti.gajula@gmail.com')->subject('You have logged !!!');
            });

            return redirect('home')->with('status', 'OTP has been Sent to registered Email Id');

          } catch (\Exception $e) {

            return view('home')->withErrors(['notSave' => $e->getMessage()]);

        }


    }

    public function verifyMobile(Request $request)
    {
        $data=$request->all();

        $verifyingCode = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->value('verify_column');

        if($verifyingCode == $data['verify_code']){
            DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['verified' => true]);
            return redirect('home')->with('status', 'Verified');
        } else {
            return redirect('home')->with('incorrect', 'Incorrect OTP');
        }

    }


    public function verifyEmail(Request $request)
    {
        $data=$request->all();

        $verifyingCode = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->value('verify_column');

        if($verifyingCode == $data['verify_code']){
            DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['verified_email' => true]);
            return redirect('home')->with('status', 'Verified');
        } else {
            return redirect('home')->with('incorrect', 'Incorrect OTP');
        }

    }
}
