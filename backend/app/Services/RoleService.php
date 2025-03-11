<?php
namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService{
    // store user
    public function allRole(){       
        $roles = Role::select('name')->get();
        return $roles;   
    }
}