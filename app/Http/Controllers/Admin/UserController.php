<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VerificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Token;
use App\Models\User;
use App\Notifications\SendEmailTokenNotification;
use App\Traits\HttpResponse;
use App\Traits\StoreFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use HttpResponse , StoreFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = QueryBuilder::for(User::class)
            ->where('id' , '!=' , auth()->user()->id)
            ->defaultSorts('-created_at')
            ->allowedSorts(['-deleted_at' ,'first_name', 'last_name', 'email', 'telephone' ])
            ->allowedFilters(['first_name', 'last_name', 'email', 'telephone'])
            ->paginate()
            ->appends($request->query());

        return $this->respond(['users' => UserResource::collection($users)->response()->getData(true)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'address' => $request->address,
        ]);

        if($request->avatar){
            $user->avatar = $this->storeFile($request->avatar , 'media/users');
            $user->save();
        }

        //get role
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role->name);

        // create token and send email verification
        $tokenData = Token::create([
            'token' =>  generateToken(),
            'email' => $request->email,
            'type' => VerificationEnum::Email
        ]);

        $user->notify(new SendEmailTokenNotification($tokenData->token));

        $data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'telephone' => $user->telephone,
            'address' => $user->address,
            'avatar' => asset('media/users/'.$user->avatar),
            'role' => $user->roles[0]->name,
        ];
        return $this->responseCreated($data , 'New user created successfully' );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->respond(new UserResource($user) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //remove user role
        $user->removeRole($user->roles[0]->name);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'address' => $request->address,
        ]);

        if($request->avatar){
            $user->avatar = $this->storeFile($request->avatar , 'media/users');
            $user->save();
        }

        //get role
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role->name);

        $data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'telephone' => $user->telephone,
            'address' => $user->address,
            'avatar' => asset('media/users/'.$user->avatar),
            'role' => $user->roles[0]->name,
        ];

        return $this->responseCreated($data , 'User Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->responseOk('User Deleted Successfully');
    }
}
