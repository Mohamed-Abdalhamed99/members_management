<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RespondsWithHttpStatusController;
use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Models\Token;
use App\Models\User;
use App\Notifications\ResendEmailNotificationToken;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentSendEmailVerificationTokenController
{
    use HttpResponse;

    public function __invoke(Request $request){

        $request->validate([
            'email'   => ['required','email','exists:students,email'],
        ]);

        Token::where('email', $request->email)
            ->where('type', VerificationEnum::Email)
            ->delete();

        $student = Student::where('email', $request->email)->first();

        if ($student->email_verified_at != null) {
            throw ValidationException::withMessages(['email' => "البريد الالكتروني مفعل"]);
        }

        $tokenData = Token::create(
            [
                'token' =>  generateToken(),
                'email' => $request->email,
                'type' => VerificationEnum::Email
            ]
        );

        \Notification::route('mail', $request->email)->notify(new ResendEmailNotificationToken($tokenData->token));

        return $this->responseOk(['message' => 'تم ارسال رمز التحقق عبر البريد الالكتروني']);
    }
}
