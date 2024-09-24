<?php

namespace App\repositories;

use App\Interfaces\MemberInterface;
use App\Models\Member;

class MemberRepository implements MemberInterface
{
    /**
     * Create a new class instance.
     */
    public function member(array $data)
    {
        $members = Member::create($data);

        return $members;
    }
    public function inviter(array $data)
    {
        
    }
}
