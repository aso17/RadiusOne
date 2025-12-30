<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = '_ms_tenants';
    protected $fillable = [
        'tenant_name',
        'slug',
        'code',
        'domain',
        'logo_path',
        'primary_color',
        'theme',
        'is_active',
        'updateBy',
    ];
}
