<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class ms_user extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Explicit table name
     */
    protected $table = 'ms_users';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',

        'is_active',

        'role_id',
        'tenant_id',

        'last_login_at',
        'last_login_ip',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(ms_role::class, 'role_id');
    }

    public function tenant()
    {
        return $this->belongsTo(ms_tenant::class, 'tenant_id');
    }
}
