<?php

namespace App\Http\Controllers\CentralApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\UserResource as ResourcesUserResource;
use App\Models\Role;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller {

    use HttpResponse;

    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index() {
        $users = QueryBuilder::for ( User::class )
        ->defaultSort( '-created_at' )
        ->allowedSorts( [ 'first_name', 'last_name' ] )
        ->allowedFilters( [ 'first_name', 'last_name', 'email', 'mobile' ] )
        ->paginate( \request()->pages ?? 25 )
        ->appends( request()->query() );

        return $this->respond( UserResource::collection( $users )->response()->getData( true ) );
    }

    /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Renderable
    */
    public function store( CreateUserRequest $request ) {
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make( $request->password ),
        ];

        $user = User::create( $data );

        //store image if exist
        if ( $request->image !== null ) {
            $filename = md5( $request->file( 'image' )->getClientOriginalName() ) . '.' . $request->file( 'image' )->getClientOriginalExtension();

            $user->addMediaFromRequest( 'image' )
            ->usingFileName( $filename )
            ->toMediaCollection( 'users' );

        }

        // assign role
        $role = Role::findOrFail( $request->role_id );
        $user-> assignRole( $role->name );
        // send verification opt by email and mobile
        return $this->responseOk('تم إضافة المستخدم بنجاح');
    }

    /**
    * Show the specified resource.
    * @param int $id
    * @return Renderable
    */
    public function show( User $user ) {
        $data = new ResourcesUserResource( $user );
        return $this->respond( $data );
    }

    /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Renderable
    */
    public function update( UpdateUserRequest $request, User $user ) {
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ];

        $user->update( $data );

        //store image if exist
        if ( $request->image !== null ) {
            $filename = md5( $request->file( 'image' )->getClientOriginalName() ) . '.' . $request->file( 'image' )->getClientOriginalExtension();

            ( $user->getFirstMedia()) ? $user->getFirstMedia('users')->delete() : true ;

            $user->addMediaFromRequest( 'image' )
            ->usingFileName( $filename )
            ->toMediaCollection( 'users' );

        }

        // assign role
        $role = Role::findOrFail( $request->role_id );
        $user-> syncRoles( [$role->name] );

        // send verification opt by email and mobile


        return $this->responseOk('تم تعديل المستخدم بنجاح');
    }

    /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Renderable
    */
    public function destroy(  User $user ) {
        $user->roles()->detach();
        $user->delete();
        return $this->responseOk( 'تم الحذف بنجاح' );
    }

    public function changePassword(ChangePasswordRequest $request , User $user)
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return $this->responseOk( 'تم تعديل كلمة المرور' );
    }
}
