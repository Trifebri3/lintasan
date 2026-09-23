<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'url',
        'path',
        'page_title',
        'referer',
        'referer_domain',
        'keyword',
        'device_type',
        'browser',
        'operating_system',
        'country',
        'province',
        'city',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime'
    ];
}
