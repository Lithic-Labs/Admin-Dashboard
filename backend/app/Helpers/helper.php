<?php

namespace App\Helpers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class helper
{
    public static function createPermissions()
    {
        $permisions = [
            [
                'name' => 'Add User',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Edit User',
                'guard_name' => 'api',
            ],

            [
                'name' => 'View User',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Add Client',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Edit Client',
                'guard_name' => 'api',
            ],
            [
                'name' => 'View Client',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Add Instance',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Edit Instance',
                'guard_name' => 'api',
            ],
            [
                'name' => 'View Instance',
                'guard_name' => 'api',
            ],        
            [
                'name' => 'View Template',
                'guard_name' => 'api',
            ],
            [
                'name' => 'Edit Reward',
                'guard_name' => 'api',
            ], 
            [
                'name' => 'View Reward',
                'guard_name' => 'api',
            ],          

        ];
        Permission::insert($permisions);
    }

    public static function createRoles()
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'api',
        ])->givePermissionTo([
            'Add User',                           
            'Edit User',
            'View User',
            'Add Client',                
            'Edit Client',                
            'View Client',
            'Add Instance',               
            'Edit Instance',               
            'View Instance',                     
            'View Template',               
            'Edit Reward', 
            'View Reward',                    
        ]);

        Role::create([
            'name' => 'Admin',
            'guard_name' => 'api',
        ])->givePermissionTo([
            'Add User',                           
            'Edit User',
            'View User',
            'Add Client',                
            'Edit Client',                
            'View Client',
            'Add Instance',               
            'Edit Instance',               
            'View Instance',                     
            'View Template',               
            'Edit Reward', 
            'View Reward', 
        ]);

        Role::create([
            'name' => 'Client',
            'guard_name' => 'api',
        ])->givePermissionTo([
            'Add User',                           
            'Edit User',
            'View User',
            'Add Client',                
            'Edit Client',                
            'View Client',
            'Add Instance',               
            'Edit Instance',               
            'View Instance',                     
            'View Template',               
            'Edit Reward', 
            'View Reward', 
        ]);
    }

   
}
