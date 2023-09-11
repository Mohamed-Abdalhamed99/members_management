<?php

namespace App\Http\Controllers\TenantApp\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\Students\UpdateProfileRequest;
use App\Http\Controllers\TenantApp\Students\Auth\StudentOptController;
use App\Models\Token;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    use HttpResponse;

    public function editProfile(UpdateProfileRequest $request)
    {
        $student = auth()->user();

        $opt = new StudentOptController();
        // check if new email or mobile make validated at null and send opt
        if($student->email != $request->email)
        {
            $student->email_verified_at = null;
            $student->save();
            Token::where('email' , $student->email)->delete();
            $student->update($request->validated());
            $opt->sendEmailOpt($request->email);
        }

        if($student->mobile != $request->mobile)
        {
            $student->mobile_verified_at = null;
            $student->save();
            Token::where('mobile' , $student->mobile)->delete();
            $student->update($request->validated());
            $opt->sendMobileOpt($request->mobile);
        }


        return $this->responseOk('تم التعديل بنجاح' );
    }

    /**
     * update student's avatar
     *
     * @param Request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all() , ['avatar' => ['required' , 'image']]);
        if($validator->fails())
        {
            return $this->responseBadRequest($validator->errors());
        }

        $student = auth()->user();
        $student->getFirstMedia('students')->delete();
        $student->addMediaFromRequest('avatar')->toMediaCollection('students');

        return $this->responseOk('تم التعديل بنجاح' );
    }
}
