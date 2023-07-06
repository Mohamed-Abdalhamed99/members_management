<?php

namespace App\Http\Controllers\CentralApp\Auth\Dashboard;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use App\Traits\HttpResponse;
use App\Traits\TwilioSMS;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\PermissionResource;

class MobileLoginController extends Controller {
    use HttpResponse, TwilioSMS;

    /**
    * send opt code to user
    */

    public function sendOPT( Request $request ) {
        $validator = Validator::make( $request->all(), [ 'mobile'  => [ 'required', 'exists:users,mobile' ] ] );

        if ( $validator->fails() ) {
            return $this->responseUnProcess( $validator->errors() );
        }

        $token = generateToken();
        $msg = ' رمز التحقق أكاديميات '  . $token;
        try {
            $this->SendSMS( $request->mobile, $msg );
        } catch( Exception $e ) {
            return $e->getMessage();
        }

        Token::create( [
            'token' =>  $token,
            'mobile' => $request->mobile,
            'type' => VerificationEnum::MOBILE
        ] );

        return $this->responseOk( 'تم ارسال رمز التحقق' );
    }

    /**
    *
    */

    public function mobileLogin( Request $request ) {
        $validator = Validator::make( $request->all(), [ 'opt'  => [ 'required', 'exists:tokens,token' ] ] );

        if ( $validator->fails() ) {
            return $this->responseUnProcess( $validator->errors() );
        }

        $opt = Token::where( 'token', $request->opt )
        ->where( 'verified', false )
        ->where( 'type', 'mobile' )
        ->first();

        if ( Carbon::parse( $opt->created_at )->addMinutes( 5 )->isPast() ) {
            throw ValidationException::withMessages( [ 'opt' => 'Token has expired' ] );
        }

        $user = User::where( 'mobile', $opt->mobile )->first();
        Token::where( 'mobile', $opt->mobile )->delete();

        $access_token = $user->createToken( 'Dashboard Admin' )->plainTextToken;

        $data[ 'user' ] = new UserResource( $user );
        $data[ 'token' ] = $access_token;
        $data[ 'role' ] = $user->roles[ 0 ]->name;
        $data[ 'permissions' ] = PermissionResource::collection( $user->getAllPermissions() ) ;

        return $this->respond( $data );
    }

    public function verifyMobile( Request $request ) {
        $validator = Validator::make( $request->all(), [ 'opt'  => [ 'required', 'exists:tokens,token' ] ] );

        if ( $validator->fails() ) {
            return $this->responseUnProcess( $validator->errors() );
        }

        $opt = Token::where( 'token', $request->opt )
        ->where( 'verified', false )
        ->where( 'type', 'mobile' )
        ->first();

        if ( Carbon::parse( $opt->created_at )->addMinutes( 5 )->isPast() ) {
            throw ValidationException::withMessages( [ 'opt' => 'Token has expired' ] );
        }

        $user = User::where( 'mobile', $opt->mobile )->first();
        $user->mobile_verified_at = Carbon::now()->toDateString();
        $user->save();
        $opt->delete();
        return $this->respond('تم تفعيل رقم الجوال' );
    }

}
