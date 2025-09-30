<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all()); //retorna todos os usuarios
    }


    public function show(User $user)
    {
        return new UserResource($user); //retorna por id de cada usuario
    }
}
