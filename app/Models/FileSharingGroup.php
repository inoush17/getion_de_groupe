<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'path',
        'sender',
        'group_id',
        'user_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
