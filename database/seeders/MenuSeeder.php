<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $mainModuleId    = DB::table('ms_modules')->where('code', 'MAIN')->value('id');
        $voucherModuleId = DB::table('ms_modules')->where('code', 'VOUCHER')->value('id');
        $systemModuleId  = DB::table('ms_modules')->where('code', 'SYSTEM')->value('id');

        /*
        |--------------------------------------------------------------------------
        | MAIN MENU (FLAT)
        |--------------------------------------------------------------------------
        */
        $mainMenus = [
            ['DASHBOARD', 'Dashboard', 'home', '/dashboard'],
            ['ROUTER', 'Router', 'layers', '/router'],
            ['MITRA', 'Mitra', 'user-plus', '/mitra'],
            ['MAP', 'Map', 'globe', '/map'],
            ['OLT', 'OLT', 'tag', '/olt'],
            ['GENIE_ACS', 'GenieACS', 'dollar-sign', '/genieacs'],
            ['ODP', 'ODP', 'file-text', '/odp'],
            ['TIKET', 'Tiket', 'life-buoy', '/tiket'],
            ['BILLING', 'Billing', 'credit-card', '/billing'],
            ['TRANSAKSI', 'Transaksi', 'dollar-sign', '/transaksi'],
            ['WHATSAPP', 'WhatsApp', 'message-circle', '/whatsapp'],
        ];

        $order = 1;
        foreach ($mainMenus as $menu) {
            DB::table('ms_menus')->insert([
                'module_id'  => $mainModuleId,
                'code'       => $menu[0],
                'menu_name'  => $menu[1],
                'icon'       => $menu[2],
                'route_name' => $menu[3],
                'parent_id'  => null,
                'order_no'   => $order++,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LANGGANAN (PARENT + CHILD)
        |--------------------------------------------------------------------------
        */
        $langgananId = DB::table('ms_menus')->insertGetId([
            'module_id'  => $mainModuleId,
            'code'       => 'LANGGANAN',
            'menu_name'  => 'Langganan',
            'icon'       => 'send',
            'route_name' => null,
            'parent_id'  => null,
            'order_no'   => 4,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $langgananChildren = [
            ['PROFILE_PELANGGAN', 'Profile Pelanggan', '/langganan/profile'],
            ['DATA_PELANGGAN', 'Data Pelanggan', '/langganan/data'],
            ['STOP_BERLANGGAN', ' Stop Berlanggan', '/langganan/stop'],
            ['ONLINE_LANGGANAN', 'Langganan Online', '/langganan/online'],
        ];

        $childOrder = 1;
        foreach ($langgananChildren as $child) {
            DB::table('ms_menus')->insert([
                'module_id'  => $mainModuleId,
                'code'       => $child[0],
                'menu_name'  => $child[1],
                'icon'       => 'dot',
                'route_name' => $child[2],
                'parent_id'  => $langgananId,
                'order_no'   => $childOrder++,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | VOUCHER (PARENT + CHILD)
        |--------------------------------------------------------------------------
        */
        $voucherId = DB::table('ms_menus')->insertGetId([
            'module_id'  => $voucherModuleId,
            'code'       => 'VOUCHER',
            'menu_name'  => 'Voucher',
            'icon'       => 'wifi',
            'route_name' => null,
            'parent_id'  => null,
            'order_no'   => 4,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $voucherChildren = [
            ['VOUCHER_PROFILE', 'Profile Voucher', '/voucher/profile'],
            ['VOUCHER_STOCK', 'Stok Voucher', '/voucher/stock'],
            ['VOUCHER_SOLD', 'Voucher Terjual', '/voucher/sold'],
            ['VOUCHER_ONLINE', 'Voucher Online', '/voucher/online'],
            ['VOUCHER_RECAP', 'Rekap Voucher', '/voucher/recap'],
            ['VOUCHER_TEMPLATE', 'Template Manager', '/voucher/template'],
        ];

        $childOrder = 1;
        foreach ($voucherChildren as $child) {
            DB::table('ms_menus')->insert([
                'module_id'  => $voucherModuleId,
                'code'       => $child[0],
                'menu_name'  => $child[1],
                'icon'       => 'dot',
                'route_name' => $child[2],
                'parent_id'  => $voucherId,
                'order_no'   => $childOrder++,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SYSTEM
        |--------------------------------------------------------------------------
        */
        DB::table('ms_menus')->insert([
            [
                'module_id' => $systemModuleId,
                'code' => 'SETTING',
                'menu_name' => 'Setting',
                'icon' => 'settings',
                'route_name' => '/setting',
                'parent_id' => null,
                'order_no' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => $systemModuleId,
                'code' => 'TOOLS',
                'menu_name' => 'Tools',
                'icon' => 'tool',
                'route_name' => '/tools',
                'parent_id' => null,
                'order_no' => 21,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => $systemModuleId,
                'code' => 'ADMIN',
                'menu_name' => 'Admin',
                'icon' => 'user-cog',
                'route_name' => '/admin',
                'parent_id' => null,
                'order_no' => 22,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => $systemModuleId,
                'code' => 'LOGS',
                'menu_name' => 'Logs',
                'icon' => 'info',
                'route_name' => '/logs',
                'parent_id' => null,
                'order_no' => 23,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
