<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingGroup extends Model
{
    use HasFactory;

    protected $fillable = [

        'path',
        'group_id',
        'user_id'
    ];


    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
