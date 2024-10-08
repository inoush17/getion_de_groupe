<?php

namespace App\repositories;
use App\Interfaces\FileSharingGroupInterface;
use App\Mail\SendNewFileEmail;
use App\Models\FileSharingGroup;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class FileSharingGroupRepository implements FileSharingGroupInterface
{
    /**
     * Create a new class instance.
     */
    public function filesharinggroup(array $data)
    {
        $filesharing = FileSharingGroup::create($data);

        $users_id = Member::where('group_id', $data['group_id'])->pluck('user_id');

        $sender = User::findOrFail($data['user_id']);
        $groupe = Group::find($data['group_id']);

        foreach ($users_id as $id) {
            $user = User::findOrFail($id);
            Mail::to($user->email)->send(new SendNewFileEmail(
                $user->email,
                $filesharing->path,
                $sender->email,
                $groupe->name

                // $data['sender'],
            ));
        }



        return $filesharing;
    }
}
