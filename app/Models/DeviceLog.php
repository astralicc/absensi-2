<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    protected $fillable = [
        'device_user_id',
        'timestamp',
        'raw_payload',
        'processed'
    ];
}
