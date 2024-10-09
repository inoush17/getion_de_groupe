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
use App\Mail\AddNewMemberEmail;
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

        $data = [
            'email' => $memberRequest->email,
            'group_id' => $group_id,
            'invited_by' => auth()->id(),
        ];


        try {
            $user = User::where('email', $memberRequest->email)->first();

            if (!$user) {

                $invitation = Invitation::create($data);

                $group = Group::findOrFail($group_id);

                $user = User::findOrFail($data['invited_by']);

                Mail::to($data['email'])->send(new InvitationEmail(
                    $data['email'],
                    $data['group_id'],
                    $user->email,
                    $group->name
                ));

                DB::commit();
                return ApiResponse::sendResponse(
                    true,
                    [new UserResource($invitation)],
                    200
                );

            } else {

                $group_members = Member::where('group_id', $data['group_id'])->get();

                if ($group_members->isNotEmpty()) {
                    foreach ($group_members as $member) {
                        Mail::to($member->email)->send(new AddNewMemberEmail(
                            $data['email'],
                            $data['group_id']
                        ));
                    }
                }    
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
}
