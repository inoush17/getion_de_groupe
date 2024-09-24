<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::prefix('v1.0.0')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgotten-password', [AuthController::class, 'forgottenPassword']);
    Route::post('otp-code', [AuthController::class, 'checkOtpCode']);
    Route::post('new-password', [AuthController::class, 'newPassword']);


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);
        
    });

    Route::get('users', [UserController::class, 'listUser']);
    Route::get('groups', [GroupController::class, 'groupList']);
    Route::get('add-member-group', [GroupController::class, 'addMember']);
    Route::get('create-member', [MemberController::class, 'member']);
    Route::post('create-group', [GroupController::class, 'group']);
});
