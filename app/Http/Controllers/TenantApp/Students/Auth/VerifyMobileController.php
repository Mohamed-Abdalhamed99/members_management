<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VerifyMobileController extends Controller
{
    public function __invoke(Request $request)
    {
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

        $student = Student::where( 'mobile', $opt->mobile )->first();
        $student->mobile_verified_at = Carbon::now()->toDateString();
        $student->save();
        $opt->delete();

        return $this->respond('تم تفعيل رقم الجوال' );
    }
}
