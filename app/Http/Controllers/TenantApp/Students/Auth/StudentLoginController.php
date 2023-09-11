<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Students\Auth\StudentOptRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\Token;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentLoginController extends Controller
{
    use HttpResponse;
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make( $request->all(), [ 'opt'  => [ 'required', 'exists:tokens,token' ] ] );

        if ( $validator->fails() ) {
            return $this->responseUnProcess( $validator->errors() );
        }

        $opt = Token::where( 'token', $request->opt )
        ->where( 'verified', false )
        ->first();

        if ( Carbon::parse( $opt->created_at )->addMinutes( 5 )->isPast() ) {
            throw ValidationException::withMessages( [ 'opt' => 'Token has expired' ] );
        }

        $student = Student::where('mobile', $opt->mobile)->orWhere('email' , $opt->email)->first();

        // verify mobile if opt type is mobile and student mobile not veified
        if($opt->type == 'mobile' && $student->mobile_verified_at == null)
        {
            $student->mobile_verified_at = now();
            $student->save();
        }

        Token::where('mobile', $student->mobile)->orWhere('email' ,  $student->email)->delete();


        $access_token = $student->createToken( 'Student' )->plainTextToken;
        $data[ 'student' ] = new StudentResource( $student );
        $data[ 'token' ] = $access_token;
        $data[ 'role' ] = 'student';

        return $this->respond($data);
    }
}
