<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\RoleService;
class AuthController extends Controller
{
    protected RoleService $roleservice;
    public function __construct(RoleService $roleservice)
    {
        $this->roleservice = $roleservice;     
    }
    public function role(){
       $responseData = $this->roleservice->allRole();
       return response()->json($responseData,200);
    }
    // login
    public function login(SignInRequest $request){
        $validateddate = $request->validated();

        try {
            if (!Auth::attempt($validateddate)) {
                throw ValidationException::withMessages([
                    'message' => 'Email Or Password Invalid',
                ]);
            } else {
                $data = [
                    'data' => auth()->user(),
                    // 'token' => auth()->user()->createToken('api-system-user')->accessToken,
                    'token' => auth()->user()->createToken('api-system-user')->accessToken,
                    'roles' => auth()->user()->getRoleNames()->get(),
                   
                ];

                return response()->json(
                    ['data' => $data, 'message' => 'Successfully Logged In'],200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
