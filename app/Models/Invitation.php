<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'email',
        'group_id',
        'invited_by',
        // 'user_id',

        
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class);
        // return $this->belongsTo(User::class, 'invited_by');
    }
}
