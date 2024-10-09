<?php

namespace App\repositories;

use App\Interfaces\GroupInterface;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;

class GroupRepository implements GroupInterface
{
    /**
     * Create a new class instance.
     */
    public function group(array $data)
    {
        $groups = Group::create($data);

        $userId = auth()->id();
        $user = User::find($userId);

        $memberData = [
            'email' => $user->email,
            'group_id' => $groups->id,
            'user_id' => $userId,
        ];

        Member::create($memberData);

        return $groups;
    }
}
