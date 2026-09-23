<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerApplication extends Model
{
    protected $fillable = [
        'institution_name',
        'pic_name',
        'email',
        'phone',
        'partnership_type',
        'logo_path',
        'address',
        'proposal',
        'status',
    ];
}
