<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\MemberRequest;
use App\Interfaces\MemberInterface;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    private MemberInterface $memberInterface;
    public function __construct(MemberInterface $memberInterface)
    {
        $this->memberInterface = $memberInterface;
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

    /**
     * Store a newly created resource in storage.
     */
    public function member(MemberRequest $memberRequest)
    {
        $data = [
            'email' => $memberRequest->email,
            'group_id' => $memberRequest->group_id,
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
            return ApiResponse::rollback($th);
        }
    }

    public function inviter(array $data)
    {
        
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
