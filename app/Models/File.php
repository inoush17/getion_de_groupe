<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'group_name'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
