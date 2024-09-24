<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'group_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
        // return $this->hasMany(User::class, 'member');
    }
    public function group()
    {
        return $this->hasMany(Group::class);
        // return $this->hasMany(User::class, 'member');
    }
}
