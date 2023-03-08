<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RespondsWithHttpStatusController;
use App\Notifications\ForgotPasswordNotification;
use App\Models\Token;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ForgotPasswordController
{

    use HttpResponse;

    public function  __invoke(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'exists:users,email']]);

       Token::where('email', $request->email)
           ->where('type', VerificationEnum::PASSWORD)
           ->delete();

        $user = User::where('email', $request->email)->firstOrFail();

        $tokenData = Token::create(
            [
                'email'     => $user->email,
                'token'     => generateToken(),
                'type'      => VerificationEnum::PASSWORD
            ]
        );

        $user->notify(new ForgotPasswordNotification($tokenData->token));

        return $this->responseOk(['message' => __('lang.password_token_sent')]);
    }


}
