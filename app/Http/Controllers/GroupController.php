<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\GroupRequest;
use App\Interfaces\GroupInterface;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    private GroupInterface $groupInterface;
    public function __construct(GroupInterface $groupInterface)
    {
        $this->groupInterface = $groupInterface;
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
    public function create()
    {
        //
    }
    public function addMember()
    {
        //
    }

    public function groupList()
    {

        $userId = auth()->id();

        $user = User::find($userId);

        $members = Member::where('email', $user->email)->get();
        $groupIds = $members->pluck('group_id');
        $groups = Group::whereIn('id',$groupIds)->get();

        return ApiResponse::sendResponse(
            true, 
            [$groups],
            'Opération effectuée.',
            201
        );

    }
    public function group(GroupRequest $groupRequest)
    {

        $data = [
            'name' => $groupRequest->name,
            'description' => $groupRequest->description,
            'admin_id'=>auth()->id()
        ];

        DB::beginTransaction();

        try {
            $user = $this->groupInterface->group($data);

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
}
