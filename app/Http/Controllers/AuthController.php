<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\ForgottenPasswordRequest;
use App\Http\Requests\Requests\LoginRequest;
use App\Http\Requests\Requests\NewPasswordRequest;
use App\Http\Requests\Requests\OtpCodeRequest;
use App\Http\Requests\Requests\RegisterRequest;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private AuthInterface $authInterface;
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(LoginRequest $loginRequest)
    {
        $data = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->login($data);

            DB::commit();

            if ($user)
                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($user)],
                    'Identifiant valide.',
                    200
                );
            else
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'Identifiant invalide.',
                    500
                );
        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = [
            'name' => $registerRequest->name,
            'email' => $registerRequest->email,
            'password' => $registerRequest->password,
            'password_confirm' => $registerRequest->password_confirm,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->register($data);

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                [new UserResource($user)],
                'Opération effectuée.',
                201
            );
        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }
    }

    public function forgottenPassword(ForgottenPasswordRequest $request)
    {
        $data = [
            'email' => $request->email,
        ];

        try {
            $user = $this->authInterface->forgottenPassword($data);

            DB::commit();

            if ($user)
                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($user)],
                    'Opération effectuée.',
                    201
                );
            else
                return ApiResponse::sendResponse(
                    false,
                    [new UserResource($user)],
                    'Opération non effectué.',
                    500
                );
        } catch (\Throwable $th) {
            // return ApiResponse::rollback($th);
            return $th;
        }
    }

    public function checkOtpCode(OtpCodeRequest $request)
    {
        $data = [
            'email' => $request->email,
            'code' => $request->code,
        ];

        DB::beginTransaction();
        try {
            $user = $this->authInterface->checkOtpCode($data);

            DB::commit();

            if ($user)

                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($user)],
                    'Code de Confirmation valide.',
                    200
                );


            return ApiResponse::sendResponse(
                false,
                'Opérations non effectué.',
                500
            );
        } catch (\Throwable $th) {

            // return ApiResponse::rollback($th);
            return $th;
        }
    }

    public function newPassword(NewPasswordRequest $request)
    {
        $data = [
            'password' => $request->password,
        ];

        DB::beginTransaction();
        try {
            $user = $this->authInterface->newPassword($data);

            DB::commit();

            if ($user)
                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($user)],
                    'Opérations effectué.',
                    200
                );


            return ApiResponse::sendResponse(
                false,
                'Opérations non effectué.',
                500
            );
        } catch (\Throwable $th) {

            // return ApiResponse::rollback($th);
            return $th;
        }
    }

    public function logout()
    {

        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->tokens()->delete();

        return ApiResponse::sendResponse(
            true,
            [],
            'Utilisateurs déconnecté.',
            200
        );
    }
}
