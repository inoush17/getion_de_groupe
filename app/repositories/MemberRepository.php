<?php

namespace App\repositories;

use App\Interfaces\MemberInterface;
use App\Mail\AddNewMemberEmail;
use App\Mail\InvitationEmail;
use App\Mail\SendEmailNewMember;
use App\Models\Group;
use App\Models\Invitation;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;

class MemberRepository implements MemberInterface
{
    /**
     * Create a new class instance.
     */
    public function member(array $data)
    {
        $newMember = Member::create($data);

        return $newMember;
    }
}
