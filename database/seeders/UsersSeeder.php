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

        // Ambil roles (key by code)
        $roles = DB::table('ms_roles')
            ->whereIn('code', ['SUPER_ADMIN', 'ADMIN', 'USER'])
            ->pluck('id', 'code');

        // Ambil tenant default
        $defaultTenantId = DB::table('ms_tenants')
            ->where('code', 'R001')
            ->value('id');

        $users = [
            [
                'name'     => 'Super Admin',
                'username' => 'superadmin',
                'email'    => 'sa@local.id',
                'role'     => 'SUPER_ADMIN',
            ],
            [
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'admin@local.id',
                'role'     => 'ADMIN',
            ],
            [
                'name'     => 'User',
                'username' => 'user',
                'email'    => 'user@local.id',
                'role'     => 'USER',
            ],
        ];

        DB::table('ms_users')->insert(
            collect($users)->map(function ($user) use ($roles, $defaultTenantId, $now) {
                return [
                    'name'              => $user['name'],
                    'username'          => $user['username'],
                    'email'             => $user['email'],
                    'password'          => Hash::make('P@ssw0rd123456'),
                    'is_active'         => true,
                    'email_verified_at' => $now,
                    'last_login_at'     => null,
                    'last_login_ip'     => null,
                    'role_id'           => $roles[$user['role']],
                    'tenant_id'         => $defaultTenantId,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            })->toArray()
        );
    }
}
