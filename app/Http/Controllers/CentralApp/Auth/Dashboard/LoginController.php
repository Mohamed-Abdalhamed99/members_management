<?php

namespace App\Http\Controllers\CentralApp\Auth\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\PermissionResource;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
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
    public function __invoke(LoginRequest $request)
    {
        if(Auth::attempt($request->validated())){
            $user = Auth::user();

            $user->tokens()->delete();
            $token = $user->createToken('Dashboard Admin')->plainTextToken;

            $data['user'] = new UserResource($user);
            $data['token'] = $token;
            $data['role'] = $user->roles[0]->name;
            //get user permissions
            $data['permissions'] = PermissionResource::collection($user->getAllPermissions()) ;

            return $this->respond($data);
        }

        throw ValidationException::withMessages([
            'message' => ['Wrong email or password'],
        ]);
    }
}
