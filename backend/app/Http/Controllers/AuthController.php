<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // login
    public function login(SignInRequest $request){
        try {
           
            if (!Auth::attempt($request->only(['email', 'password']))) {
                throw ValidationException::withMessages([
                    'message' => 'Email Or Password Invalid',
                ]);
            } else {
                $data = [
                    'data' => Auth::user(),
                    'token' => Auth::user()->createToken('api-system-user')->accessToken,
                    'roles' => Auth::user()->getRoleNames(),
                ];
                return response()->json(
                    ['data' => $data, 'message' => 'Successfully Logged In'],
                    200
                );
            }
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => 'Login Faild',],400);
        }

    }
}
