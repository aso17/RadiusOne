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

        $roles = DB::table('ms_roles')->pluck('id', 'code');

        $menus = DB::table('ms_menus')
            ->select('id', 'code', 'module_id')
            ->get();

        $permissions = [];

        /*
        |------------------------------------------------------
        | SUPER ADMIN — FULL ACCESS
        |------------------------------------------------------
        */
        foreach ($menus as $menu) {
            $permissions[] = [
                'role_id'    => $roles['SUPER_ADMIN'],
                'module_id'  => $menu->module_id,
                'menu_id'    => $menu->id,
                'can_view'   => true,
                'can_create' => true,
                'can_update' => true,
                'can_delete' => true,
                'can_export' => true,
                'is_active'  => true,
                'created_by' => 'system',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        /*
        |------------------------------------------------------
        | ADMIN — SEMUA KECUALI LOGS & TOOLS
        |------------------------------------------------------
        */
        foreach ($menus as $menu) {

            if (in_array($menu->code, [
                'LOGS',
                'TOOLS'
            ])) {
                continue;
            }

            $permissions[] = [
                'role_id'    => $roles['ADMIN'],
                'module_id'  => $menu->module_id,
                'menu_id'    => $menu->id,
                'can_view'   => true,
                'can_create' => true,
                'can_update' => true,
                'can_delete' => false,
                'can_export' => true,
                'is_active'  => true,
                'created_by' => 'system',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        /*
        |------------------------------------------------------
        | USER — VIEW ONLY
        |------------------------------------------------------
        */
        $userAllowedMenus = [
            'DASHBOARD',
            'BILLING',
            'TIKET',
            'VOUCHER',
            'VOUCHER_PROFILE',
            'VOUCHER_STOCK',
        ];

        foreach ($menus as $menu) {
            if (!in_array($menu->code, $userAllowedMenus)) {
                continue;
            }

            $permissions[] = [
                'role_id'    => $roles['USER'],
                'module_id'  => $menu->module_id,
                'menu_id'    => $menu->id,
                'can_view'   => true,
                'can_create' => $menu->code === 'TIKET', // user boleh buat tiket
                'can_update' => false,
                'can_delete' => false,
                'can_export' => false,
                'is_active'  => true,
                'created_by' => 'system',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('ms_role_menu_permissions')->insert($permissions);
    }
}
