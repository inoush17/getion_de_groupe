<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listUser()
    {
        return ApiResponse::sendResponse(
            true, 
            [new UserResource(User::all())],
            'Opération effectuée.',
            201
        );

    }
}
