<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService{

    // store user
    public function storeUser(
        string $name,
        string $email,
        string $password,
        string $usertype
    ){
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'usertype' =>  $usertype,        
             ]);
             $user->assignRole($usertype);
             $type = 200;
             $msg = "User Registration Successfully";
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $type = 400;
            $msg = "User Registration Failed";
        }
        return ([$type,$msg]);
    }
}