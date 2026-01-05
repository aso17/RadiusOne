<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ms_sub_menu extends Model
{
    protected $table = 'ms_sub_menus';

    protected $fillable = [
        'menu_id',
        'sub_menu_name',
        'code',
        'route_name',
        'order_no',
        'is_active',
    ];

    public function menu()
    {
        return $this->belongsTo(ms_menu::class, 'menu_id');
    }
}
