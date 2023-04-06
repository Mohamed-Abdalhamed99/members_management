<?php

namespace App\Http\Controllers\TenantApp\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationFormRequest;
use App\Http\Resources\UserResource;
use App\Models\Token;
use App\Models\User;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use Illuminate\Support\Facades\Hash;

class RegistrationController
{
    use HttpResponse , StoreFile;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(RegistrationFormRequest $request)
    {
        Token::where('email', $request->email)->where('type', VerificationEnum::Email)->delete();

        $user = User::create([
             'first_name'   => $request->first_name,
             'last_name'    => $request->last_name,
             'email'        => $request->email,
             'gender'       => $request->gender,
             'telephone'    => $request->telephone,
             'password'     => Hash::make($request->password),
             'status'       => 1
        ])
            ->assignRole('client');

        if($request->avatar){
            $user->avatar = $this->storeFile($request->avatar , 'media/users');
            $user->save();
        }

        $tokenData = Token::create([
            'token' =>  generateToken(),
            'email' => $request->email,
            'type' => VerificationEnum::Email
        ]);

        $user->notify(new SendEmailTokenNotification($tokenData->token));

        return  $this->responseOk([
            'message' => __('lang.email_verified_sent'),
        ]);

    }




}
