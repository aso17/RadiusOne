<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleMenuPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $roles   = DB::table('ms_roles')->pluck('id', 'code');
        $modules = DB::table('ms_modules')->pluck('id', 'code');

        // Ambil menu + module
        $menus = DB::table('ms_menus')
            ->select('id', 'code', 'module_id')
            ->get();

        $permissions = [];

        /*
        |----------------------------------------------------------------------
        | SUPER ADMIN — FULL ACCESS
        |----------------------------------------------------------------------
        */
        foreach ($menus as $menu) {
            $permissions[] = [
                'role_id'     => $roles['SUPER_ADMIN'],
                'module_id'   => $menu->module_id,
                'menu_id'     => $menu->id,
                'can_view'    => true,
                'can_create'  => true,
                'can_update'  => true,
                'can_delete'  => true,
                'can_export'  => true,
                'is_active'   => true,
                'created_by'  => 'system',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        /*
        |----------------------------------------------------------------------
        | ADMIN — LIMITED SYSTEM ACCESS
        |----------------------------------------------------------------------
        */
        foreach ($menus as $menu) {

            // Admin tidak boleh System
            if (in_array($menu->code, [
                'SYSTEM_TOOLS',
                'SOFTWARE_LOGS',
                'NEIGHBOR_LIST'
            ])) {
                continue;
            }

            $permissions[] = [
                'role_id'     => $roles['ADMIN'],
                'module_id'   => $menu->module_id,
                'menu_id'     => $menu->id,
                'can_view'    => true,
                'can_create'  => true,
                'can_update'  => true,
                'can_delete'  => false,
                'can_export'  => true,
                'is_active'   => true,
                'created_by'  => 'system',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        /*
        |----------------------------------------------------------------------
        | USER — VIEW ONLY
        |----------------------------------------------------------------------
        */
        $userAllowedMenus = [
            'DASHBOARD',
            'UNPAID_INVOICE',
            'ONLINE_PAYMENT',
            'SUPPORT_TICKETS',
        ];

        foreach ($menus as $menu) {
            if (!in_array($menu->code, $userAllowedMenus)) {
                continue;
            }

            $permissions[] = [
                'role_id'     => $roles['USER'],
                'module_id'   => $menu->module_id,
                'menu_id'     => $menu->id,
                'can_view'    => true,
                'can_create'  => false,
                'can_update'  => false,
                'can_delete'  => false,
                'can_export'  => false,
                'is_active'   => true,
                'created_by'  => 'system',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        DB::table('ms_role_menu_permissions')->insert($permissions);
    }
}
