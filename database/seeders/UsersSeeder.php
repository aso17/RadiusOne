<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Ambil role ID (berdasarkan code, bukan id)
        $superAdminRoleId = DB::table('ms_roles')->where('code', 'SUPER_ADMIN')->value('id');
        $adminRoleId      = DB::table('ms_roles')->where('code', 'ADMIN')->value('id');

        // Ambil tenant ID (opsional)
        $defaultTenantId = DB::table('ms_tenants')->where('code', 'DEFAULT')->value('id');

        DB::table('ms_users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@radiusone.local',
                'username' => 'superadmin',
                'password' => Hash::make('P@ssw0rd123456'),
                'is_active' => true,
                'email_verified_at' => $now,
                'last_login_at' => null,
                'last_login_ip' => null,
                'role_id' => $superAdminRoleId,
                'tenant_id' => $defaultTenantId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@radiusone.local',
                'username' => 'admin',
                'password' => Hash::make('P@ssw0rd123456'),
                'is_active' => true,
                'email_verified_at' => $now,
                'last_login_at' => null,
                'last_login_ip' => null,
                'role_id' => $adminRoleId,
                'tenant_id' => $defaultTenantId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
