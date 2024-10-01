<?php

namespace App\repositories;

use App\Interfaces\MemberInterface;
use App\Mail\AddNewMemberEmail;
use App\Mail\InvitationEmail;
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
        $members = Member::create($data);

        
        Mail::to($data['email'])->send(new AddNewMemberEmail($data['email']));


        return $members;
    }
    // public function invitation(array $data)
    // {
    //     $invite = Invitation::create($data);

    //     Mail::to($data['email'])->send(new InvitationEmail($data['email']));

    //     return $invite;
    // }

    public function Token(string $token)
    {
        $token = Invitation::where('token', $token)->first();

        return $token;
    }
}
