<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\FileSharingGroupRequest;
use App\Interfaces\FileSharingGroupInterface;
use App\Resources\UserResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileSharingGroupController extends Controller
{
    private FileSharingGroupInterface $fileSharingGroupInterface;
    public function __construct(FileSharingGroupInterface $fileSharingGroupInterface)
    {
        $this->fileSharingGroupInterface = $fileSharingGroupInterface;
    }

    public function filesharinggroup(FileSharingGroupRequest $filesharingsroupRequest)
    {
        $path = 'null';

        if ($filesharingsroupRequest->hasFile('file')){
            $file = $filesharingsroupRequest->file('file');
            $path = $file->getClientOriginalPath();
        }

        $data = [
            'email' => $filesharingsroupRequest->email,
            'path' => $path,
            'sender' => 'inoush',
            // 'sender' =>$fileSharingGroupRequest->sender,
            'group_id' => 2,
            // 'group_id' =>$fileSharingGroupRequest->group_id,
            'user_id' => 2,
            // 'user_id' =>$fileSharingGroupRequest->user_id,
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
}
