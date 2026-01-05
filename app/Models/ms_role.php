<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ms_role extends Model
{
    protected $table = 'ms_roles';

    protected $fillable = [
        'role_name',
        'code',
        'is_active',
    ];
}
