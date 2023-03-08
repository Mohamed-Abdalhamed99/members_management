<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyPasswordResetRequest;
use App\Models\Token;
use App\Models\User;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController
{
    use HttpResponse;

    public function __invoke(VerifyPasswordResetRequest $request)
    {

        $token = Token::where('token', $request->token)
            ->where('verified', false)
            ->where('type', 'password')
            ->first();

        if (Carbon::parse($token->created_at)->addMinutes(60)->isPast()) {
            throw ValidationException::withMessages(['token' => 'Token has expired']);
        }

        User::where('email', $token->email)->update(['password' => Hash::make($request->password)]);

        $token->delete();

        return $this->responseOk(['message' => __('lang.password_updated')]);
    }
}
