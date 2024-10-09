<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'admin_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'member');
    }


    public function fileSharingGroups()
    {
        return $this->hasMany(FileSharingGroup::class, 'group_id');
    }
    // public function admin()
    // {
    //     return $this->belongsTo(User::class, 'admin_id');
    // }
}
