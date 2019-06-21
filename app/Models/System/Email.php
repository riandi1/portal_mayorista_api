<?php

namespace App\Models\System;

use App\Models\Model;

class Email extends Model
{
    protected $fillable = [
        'address',
        'password',
        'entry_type',
        'entry_server',
        'entry_port',
        'exit_server',
        'exit_port',
        'auth_required'
    ];
}
