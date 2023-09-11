<?php

namespace Modules\Student\Http\Controllers;

use App\Enums\VerificationEnum;
use App\Models\Student;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Http\Requests\CreateStudentRequest;
use Modules\Student\Transformers\StudentsResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use Modules\Student\Http\Requests\UpdateStudentRequest;
use Modules\Student\Transformers\ShowStudentsResource;

class StudentController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $students = QueryBuilder::for ( Student::class )
        ->defaultSort( '-created_at' )
        ->allowedSorts( [ 'first_name', 'last_name' ,'join_date'] )
        ->allowedFilters( [ 'first_name', 'last_name', 'email', 'mobile' ] )
        ->paginate( \request()->pages ?? 25 )
        ->appends( request()->query() );

        return $this->respond( StudentsResource::collection( $students )->response()->getData( true ) );
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateStudentRequest $request)
    {
        $student = Student::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'gender'       => $request->gender,
            'mobile'    => $request->mobile,
            'birth_date'    => $request->birth_date,
            'address'    => $request->address,
            'code' =>   generateStudentCode(),
            'join_date' => Carbon::now()->toDateString(),
        //  'password'     => Hash::make($request->password),
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
            'message' => " تم إضافة طالب جديد بنجاح",
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Student $student)
    {
        return $this->respond(new ShowStudentsResource($student));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        if($request->avatar != null){
            $student->getFirstMedia('students')->delete();
            $student->addMediaFromRequest('avatar')->toMediaCollection('students');
        }

        return $this->responseOk('تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return  $this->responseOk('تم الحذف بنجاح');
    }
}
