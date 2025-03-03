<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SignUpRequest $request)
    {
       list($type,$msg) = $this->userservice->storeUser(
            name:$request('name'),
            email:$request('email'),
            password:$request('password'),
       );
       return response()->json($msg,$type);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
