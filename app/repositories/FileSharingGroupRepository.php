<?php

namespace App\repositories;
use App\Interfaces\FileSharingGroupInterface;
use App\Mail\SendNewFileEmail;
use App\Models\FileSharingGroup;
use Illuminate\Support\Facades\Mail;

class FileSharingGroupRepository implements FileSharingGroupInterface
{
    /**
     * Create a new class instance.
     */
    public function filesharinggroup(array $data)
    {
        $filesharing = FileSharingGroup::create($data);

        // Mail::to($data['email'])->send(new SendNewFileEmail(
        //     $data['email']
        // ));

        return $filesharing;
    }
}
