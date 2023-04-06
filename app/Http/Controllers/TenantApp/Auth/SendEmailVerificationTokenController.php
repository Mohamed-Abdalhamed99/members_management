<?php

namespace App\Http\Controllers\TenantApp\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RespondsWithHttpStatusController;
use App\Http\Resources\UserResource;
use App\Models\Token;
use App\Models\User;
use App\Notifications\ResendEmailNotificationToken;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SendEmailVerificationTokenController
{
    use HttpResponse;

    public function __invoke(Request $request){

        $request->validate([
            'email'   => ['required','email','exists:users,email'],
        ]);

        Token::where('email', $request->email)
            ->where('type', VerificationEnum::Email)
            ->delete();

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at != null) {
            throw ValidationException::withMessages(['email' => __('lang.email_already_verified')]);
        }

        $tokenData = Token::create(
            [
                'token' =>  generateToken(),
                'email' => $request->email,
                'type' => VerificationEnum::Email
            ]
        );

        \Notification::route('mail', $request->email)->notify(new ResendEmailNotificationToken($tokenData->token));

        return $this->responseOk(['message' => __('lang.email_verified_sent')]);
    }
}
