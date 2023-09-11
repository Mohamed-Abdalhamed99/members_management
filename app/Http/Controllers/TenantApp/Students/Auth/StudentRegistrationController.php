<?php

namespace App\Http\Controllers\TenantApp\Students\Auth;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Auth\StudentRegistrationFormRequest;
use App\Models\Student;
use App\Models\Token;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationController extends Controller
{
    use HttpResponse , StoreFile;
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(StudentRegistrationFormRequest $request)
    {

        $student = Student::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'gender'       => $request->gender,
            'mobile'    => $request->mobile,
            'birth_date'    => $request->birth_date,
            'address'    => $request->address,
            'code' => generateStudentCode(),
            'join_date' => Carbon::now()->toDateString(),
        //     'password'     => Hash::make($request->password),
             'status'       => 1
        ]);

        if($request->avatar){
            $student->addMediaFromRequest('avatar')->toMediaCollection('students');
        }

        $tokenData = Token::create([
            'token' =>  generateToken(),
            'email' => $request->email,
            'type' => VerificationEnum::Email
        ]);

        $student->notify(new SendEmailTokenNotification($tokenData->token));

        return  $this->responseOk([
            'message' => " تم ارسال رمز التحقق برجاءالتحقق من بريد الالكتروني  ",
        ]);

    }




}
