<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MenuRepository
{
    public static function getByRole(int $roleId)
    {
        return DB::table('ms_role_menu_permissions as rp')
            ->join('ms_menus as m', 'm.id', '=', 'rp.menu_id')
            ->join('ms_modules as mo', 'mo.id', '=', 'rp.module_id')
            ->where('rp.role_id', $roleId)
            ->where('rp.is_active', true)
            ->where('m.is_active', true)
            ->select([
                'mo.id   as module_id',
                'mo.code as module_code',
                'mo.module_name',

                'm.id    as menu_id',
                'm.code  as menu_code',
                'm.menu_name',
                'm.icon',
                'm.route_name',
                'm.parent_id',
                'm.order_no',

                'rp.can_view',
                'rp.can_create',
                'rp.can_update',
                'rp.can_delete',
                'rp.can_export',
            ])
            ->orderBy('mo.id')
            ->orderBy('m.order_no')
            ->get();
    }
}
