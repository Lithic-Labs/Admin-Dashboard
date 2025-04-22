<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\TemplateController; 
use App\Http\Controllers\RewardController;
use Illuminate\Http\Request;

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api', 'role:Super Admin', 'permission:View Template']],
    function () {
        Route::get('templates', [TemplateController::class, 'index']); 
        Route::post('storeUser', [UserController::class, 'store']);
        Route::post('storeInstance', [TemplateController::class, 'store']);
        Route::get('role', [AuthController::class, 'role']);
        Route::get('viewAllClientInstance/{id}', [TemplateController::class, 'getAllClientInstances']);
    }
);

Route::group(['middleware' => ['auth:api', 'role:Client', 'permission:View Template']],
    function () { 
        Route::get('viewClientInstance/{id}', [TemplateController::class, 'getClientInstances']);
        Route::post('updateInstance', [TemplateController::class, 'updateInstance']);   
        Route::post('createrewards', [RewardController::class, 'store']);     
       
    }
);

Route::get('editrewards/{id}', [RewardController::class, 'edit']); 
Route::post('updaterewards/{id}', [RewardController::class, 'update']); 

   
       


