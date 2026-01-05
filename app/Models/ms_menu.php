<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ms_menu extends Model
{
    protected $table = 'ms_menus';

    protected $fillable = [
        'module_id',
        'menu_name',
        'code',
        'route_name',
        'icon',
        'order_no',
        'is_active',
    ];

    public function module()
    {
        return $this->belongsTo(ms_modul::class, 'module_id');
    }
}
