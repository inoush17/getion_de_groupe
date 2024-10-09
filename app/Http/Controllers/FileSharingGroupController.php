<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\FileSharingGroupRequest;
use App\Interfaces\FileSharingGroupInterface;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FileSharingGroupController extends Controller
{
    private FileSharingGroupInterface $fileSharingGroupInterface;
    public function __construct(FileSharingGroupInterface $fileSharingGroupInterface)
    {
        $this->fileSharingGroupInterface = $fileSharingGroupInterface;
    }

    public function filesharinggroup(FileSharingGroupRequest $filesharingroupRequest, $groupId, $user_id)
    {

        $data = [

            'path' => $filesharingroupRequest->file,
            'group_id' => $groupId,
            'user_id' => $user_id

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

        $fileInfos = [];

        $group = Group::findOrFail($groupId);

        $files = $group->filesharingGroups()->get(['id', 'path', 'created_at', 'user_id']);

        foreach ($files as $file) {
            $infoFile = [];
            $infoUser = [];
            array_push($infoUser, User::findOrFail($file->user_id));
            array_push($infoFile, $file);
            $allInfos = [
                'user' => $infoUser,
                'file' => $infoFile,
            ];
            array_push($fileInfos, $allInfos);
        }

        return response()->json(['file_sharing_groups' => $fileInfos]);
    }
}
