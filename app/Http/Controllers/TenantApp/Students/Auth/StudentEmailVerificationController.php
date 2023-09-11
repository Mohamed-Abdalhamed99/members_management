<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Models\Token;
use App\Models\User;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentEmailVerificationController
{
    use HttpResponse;
    public function __invoke(VerifyEmailRequest $request)
    {

        $token = Token::where('token', $request->token)
            ->where('verified', false)
            ->where('type', 'email')
            ->first();

        if (Carbon::parse($token->created_at)->addMinutes(60)->isPast()) {
            throw ValidationException::withMessages(['token' => 'Token has expired']);
        }

        Student::where('email', '=', $token->email)
            ->where('email_verified_at', '=', null)
            ->update(['email_verified_at' => now()]);

        $token->delete();

        return  $this->responseOk(['message' => 'تم تفعيل الحساب بنجاح']);
    }
}
