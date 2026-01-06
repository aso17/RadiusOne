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

        // Ambil module ID
        $usersModuleId    = DB::table('ms_modules')->where('code', 'USERS')->value('id');
        $settingsModuleId = DB::table('ms_modules')->where('code', 'SETTINGS')->value('id');
        $financeModuleId  = DB::table('ms_modules')->where('code', 'FINANCE')->value('id');
        $systemModuleId   = DB::table('ms_modules')->where('code', 'SYSTEM')->value('id');

        /*
        |--------------------------------------------------------------------------
        | USERS SESSION (MODULE: USERS)
        |--------------------------------------------------------------------------
        */
        $usersSessionId = DB::table('ms_menus')->insertGetId([
            'module_id'  => $usersModuleId,
            'code'       => 'USERS_SESSION',
            'menu_name'  => 'Users Session',
            'icon'       => 'bar-chart',
            'route_name' => null,
            'parent_id'  => null,
            'order_no'   => 1,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('ms_menus')->insert([
            'module_id'  => $usersModuleId,
            'code'       => 'DASHBOARD',
            'menu_name'  => 'Dashboard',
            'icon'       => 'home',
            'route_name' => '/dashboard',
            'parent_id'  => $usersSessionId,
            'order_no'   => 1,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | APP SETTINGS (MODULE: SETTINGS)
        |--------------------------------------------------------------------------
        */
        $appSettingsId = DB::table('ms_menus')->insertGetId([
            'module_id'  => $settingsModuleId,
            'code'       => 'APP_SETTINGS',
            'menu_name'  => 'App Settings',
            'icon'       => 'settings',
            'route_name' => null,
            'parent_id'  => null,
            'order_no'   => 1,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('ms_menus')->insert([
            [
                'module_id'  => $settingsModuleId,
                'code'       => 'ROUTER_NAS',
                'menu_name'  => 'Router [ NAS ]',
                'icon'       => 'git-branch',
                'route_name' => '/settings/router-nas',
                'parent_id'  => $appSettingsId,
                'order_no'   => 1,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id'  => $settingsModuleId,
                'code'       => 'ODP_POP',
                'menu_name'  => 'ODP | POP Data',
                'icon'       => 'layers',
                'route_name' => '/settings/odp-pop',
                'parent_id'  => $appSettingsId,
                'order_no'   => 2,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id'  => $settingsModuleId,
                'code'       => 'SERVICE_PLAN',
                'menu_name'  => 'Service Plan',
                'icon'       => 'package',
                'route_name' => '/settings/service-plan',
                'parent_id'  => $appSettingsId,
                'order_no'   => 3,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FINANCE (MODULE: FINANCE)
        |--------------------------------------------------------------------------
        */
        $financeReportId = DB::table('ms_menus')->insertGetId([
            'module_id'  => $financeModuleId,
            'code'       => 'FINANCE_REPORT',
            'menu_name'  => 'Finance Report',
            'icon'       => 'dollar-sign',
            'route_name' => null,
            'parent_id'  => null,
            'order_no'   => 1,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('ms_menus')->insert([
            [
                'module_id'  => $financeModuleId,
                'code'       => 'UNPAID_INVOICE',
                'menu_name'  => 'Unpaid Invoice',
                'icon'       => 'file-text',
                'route_name' => '/finance/unpaid-invoice',
                'parent_id'  => $financeReportId,
                'order_no'   => 1,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | SYSTEM (MODULE: SYSTEM)
        |--------------------------------------------------------------------------
        */
        DB::table('ms_menus')->insert([
            'module_id'  => $systemModuleId,
            'code'       => 'SUPPORT_TICKETS',
            'menu_name'  => 'Support Tickets',
            'icon'       => 'life-buoy',
            'route_name' => '/support-tickets',
            'parent_id'  => null,
            'order_no'   => 1,
            'is_active'  => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
