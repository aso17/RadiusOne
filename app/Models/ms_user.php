<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ✅ Tambahkan ini

class ms_user extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // ✅ Tambahkan HasApiTokens

    protected $table = 'ms_users';

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

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(ms_role::class, 'role_id');
    }

    public function tenant()
    {
        return $this->belongsTo(ms_tenant::class, 'tenant_id');
    }
}
