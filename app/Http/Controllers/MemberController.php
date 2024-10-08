<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\MemberRequest;
use App\Interfaces\MemberInterface;
use App\Mail\InvitationEmail;
use App\Models\Group;
use App\Models\Invitation;
use App\Models\Member;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Str;

class MemberController extends Controller
{

    private MemberInterface $memberInterface;
    public function __construct(MemberInterface $memberInterface)
    {
        $this->memberInterface = $memberInterface;
    }

    public function member(MemberRequest $memberRequest, $group_id)
    {
        DB::beginTransaction();

        try {
            $user = User::where('email', $memberRequest->email)->first();

            if (!$user) {

                $data = [
                    'email' => $memberRequest->email,
                    'group_id' => $group_id,
                    'invited_by' => auth()->id(),
                ];
    
                $invitation = Invitation::create($data);

                $groupe = Group::findOrFail($group_id);

                $user = User::findOrFail($data['invited_by']);

                Mail::to($data['email'])->send(new InvitationEmail(
                    $data['email'],
                    $data['group_id'],
                    $user->email,
                    $groupe->name
                ));

                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($invitation)],
                    200
                );
            }
            
            $data = [
                'email' => $memberRequest->email,
                'group_id' => $group_id,
                'user_id' => $user->id 
            ];

            $newMember = $this->memberInterface->member($data);

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                [new UserResource($newMember)],
                'Opération effectuée.',
                201
            );
        } catch (\Throwable $th) {
            DB::rollBack();

            return ApiResponse::sendResponse(
                false,
                ['error' => $th->getMessage()],
                500
            );
        }
    }

    public function membersGroup($id)
    {

        try {

            $memberGroup = Member::where("group_id", $id)->get();

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                [$memberGroup],
                'Opération effectuée.',
                200
            );
        } catch (\Throwable $th) {
            DB::rollBack();

            return ApiResponse::sendResponse(
                false,
                ['error' => $th->getMessage()],
                500
            );
        }
    }

    public function invitation(MemberRequest $memberRequest)
    {
        // Créer un token unique
        // $token = str()::random(32);
        // $url = route('invitation', ['token' => $token]);

        // Enregistrer l'invitation
        $data = [
            'email' => $memberRequest->email,
            'url' => $memberRequest->url,
            'group_id' => $memberRequest->groupId,
            'invited_by' => $memberRequest->userName,
            'token' => $memberRequest->token,
            'is_registered' => false,
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


        //     return $invitation;
        // }
    }
}
