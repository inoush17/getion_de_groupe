<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\FileSharingGroupRequest;
use App\Interfaces\FileSharingGroupInterface;
use App\Models\FileSharingGroup;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileSharingGroupController extends Controller
{
    private FileSharingGroupInterface $fileSharingGroupInterface;
    public function __construct(FileSharingGroupInterface $fileSharingGroupInterface)
    {
        $this->fileSharingGroupInterface = $fileSharingGroupInterface;
    }

    public function filesharinggroup(FileSharingGroupRequest $filesharingroupRequest, $groupId)
    {

        $data = [

            'path' => $filesharingroupRequest->file,
           'group_id' => $groupId,
           
        ];

        DB::beginTransaction();

        try {
            $file = $this->fileSharingGroupInterface->filesharinggroup($data);

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                [new UserResource($file)],
                'Opération effectuée.',
                201
            );
        } catch (\Throwable $th) {

            // return ApiResponse::rollback($th);
            return $th;
        }
    }

    public function fileSharingGroupList($groupId)
    {

        $group = Group::findOrFail($groupId);

        $files = $group->fileSharingGroups()->get(['id', 'path', 'created_at', 'user_id']);


return response()->json(['file_sharing_groups' => $files]);

        // return ApiResponse::sendResponse(
        //     true,
        //     [new UserResource(FileSharingGroup::all())],
        //     'Opération effectuée.',
        //     201
        // );
    }
}
