<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\MemberRequest;
use App\Interfaces\MemberInterface;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class MemberController extends Controller
{

    private MemberInterface $memberInterface;
    public function __construct(MemberInterface $memberInterface)
    {
        $this->memberInterface = $memberInterface;
    }

    public function member(MemberRequest $memberRequest)
    {
        $data = [
            'email' => $memberRequest->email,
            // 'group_id' => $memberRequest->group_id,
        ];

        DB::beginTransaction();

        try {
            $user = $this->memberInterface->member($data);

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                [new UserResource($user)],
                'Opération effectuée.',
                201
            );
        } catch (\Throwable $th) {
            // return ApiResponse::rollback($th);
            return $th;
        }
    }

    // public function invitation(MemberRequest $memberRequest)
    // {
    //     // Créer un token unique
    //     $token = str()::random(32);
    //     $url = route('invitation', ['token' => $token]);

    //     // Enregistrer l'invitation
    //     $data = [
    //         'email' => $memberRequest->email,
    //         'url' => $memberRequest->url,
    //         'group_id' => $memberRequest->groupId,
    //         'invited_by' => $memberRequest->userId,
    //         'token' => $memberRequest->token,
    //         'is_registered' => false,
    //     ];

    //     DB::beginTransaction();

    //     try {
    //         $user = $this->memberInterface->member($data);

    //         DB::commit();

    //         return ApiResponse::sendResponse(
    //             true,
    //             [new UserResource($user)],
    //             'Opération effectuée.',
    //             201
    //         );
    //     } catch (\Throwable $th) {
    //         // return ApiResponse::rollback($th);
    //         return $th;
    //     }
        

    //     return $invitation;
    // }
}
