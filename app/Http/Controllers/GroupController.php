<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\GroupRequest;
use App\Interfaces\GroupInterface;
use App\Models\Group;
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
        return ApiResponse::sendResponse(
            true, 
            [new UserResource(Group::all())],
            'Opération effectuée.',
            201
        );

    }
    public function group(GroupRequest $groupRequest)
    {
        $data = [
            'name' => $groupRequest->name,
            'description' => $groupRequest->description,
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
