<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'motivation',
        'bio',
        'photo_path',
        'role',
        'status'
    ];
}
