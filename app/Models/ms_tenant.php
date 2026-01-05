<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ms_tenant extends Model
{
    use SoftDeletes;

    protected $table = 'ms_tenants';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'domain',
        'logo_path',
        'primary_color',
        'theme',
        'is_active',
        'created_by',
        'updated_by',
    ];


    /* =======================
     |  Relationships
     ======================= */

    public function createdBy()
    {
        return $this->belongsTo(ms_user::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(ms_user::class, 'updated_by');
    }
}
