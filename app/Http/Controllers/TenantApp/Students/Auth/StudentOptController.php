<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Auth\StudentOptRequest;
use App\Models\Student;
use App\Models\Token;
use App\Traits\HttpResponse;
use App\Traits\TwilioSMS;
use Exception;
use App\Notifications\SendEmailTokenNotification;

class StudentOptController extends Controller
{
    use HttpResponse , TwilioSMS;

    public function sendOPT(StudentOptRequest $request)
    {

        if($request->email != null)
        {
            $this->deleteOptTokens($request->email);
            return $this->sendEmailOpt($request->email);
        }

        if($request->mobile != null)
        {
            $this->deleteOptTokens($request->mobile);
            return $this->sendMobileOpt($request->mobile);
        }
    }

    public function sendEmailOpt($email)
    {
        $token = generateToken();
         Token::create([
            'token' =>  $token,
            'email' => $email,
            'type' => VerificationEnum::Email
        ]);
        $student = Student::where('email' , $email)->first();
        $student->notify(new SendEmailTokenNotification($token));

        return $this->responseOk( 'تم ارسال رمز التحقق' );
    }

    public function sendMobileOpt($mobile)
    {
        $token = generateToken();
        $msg = ' رمز التحقق أكاديميات '  . $token;
        try {
            $this->SendSMS( $mobile, $msg );
        } catch( Exception $e ) {
            return $e->getMessage();
        }

        Token::create( [
            'token' =>  $token,
            'mobile' => $mobile,
            'type' => VerificationEnum::MOBILE
        ] );

        return $this->responseOk( 'تم ارسال رمز التحقق' );
    }


    public function deleteOptTokens($info) : void
    {
        $student = Student::where('mobile', $info)->orWhere('email' , $info)->first();
        Token::where('mobile', $student->mobile)->orWhere('email' ,  $student->email)->delete();
    }
}
