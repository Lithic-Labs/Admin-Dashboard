<?php
namespace App\Services;

use App\Models\User;

class UserService{

    // store user
    public function storeUser(
        string $name,
        string $email,
        string $password,
    ){
        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)         
             ]);
             $type = 200;
             $msg = "User Registration Successfully";
        } catch (\Throwable $th) {
            $type = 200;
            $msg = "User Registration Failed";
        }
        return ([$type,$msg]);
    }
}