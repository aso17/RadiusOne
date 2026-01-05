<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ms_tenant as Tenant;
class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::insert([
            [
                'name'          => 'Radius One',
                'slug'          => 'radiusone',
                'code'          => 'R001',
                'domain'        => 'localhost',

                'logo_path'     => '/logos/radiusone.png',
                'primary_color' => '#2563EB',
                'theme'         => 'light',

                'is_active'     => true,

                // SYSTEM
                'created_by'    => null,
                'updated_by'    => null,
            ],
            [
                'name'          => 'Finance App',
                'slug'          => 'finance',
                'code'          => 'F001',
                'domain'        => 'finance.test',

                'logo_path'     => '/logos/finance.png',
                'primary_color' => '#16A34A',
                'theme'         => 'light',

                'is_active'     => true,

                'created_by'    => null,
                'updated_by'    => null,
            ],
            [
                'name'          => 'HRIS System',
                'slug'          => 'hris',
                'code'          => 'H001',
                'domain'        => 'hris.test',

                'logo_path'     => '/logos/hris.png',
                'primary_color' => '#DC2626',
                'theme'         => 'light',

                'is_active'     => true,

                'created_by'    => null,
                'updated_by'    => null,
            ],
            [
                'name'          => 'Inventory Pro',
                'slug'          => 'inventory',
                'code'          => 'I001',
                'domain'        => 'inventory.test',

                'logo_path'     => '/logos/inventory.png',
                'primary_color' => '#7C3AED',
                'theme'         => 'dark',

                'is_active'     => true,

                'created_by'    => null,
                'updated_by'    => null,
            ],
            [
                'name'          => 'CRM Plus',
                'slug'          => 'crm',
                'code'          => 'C001',
                'domain'        => 'crm.test',

                'logo_path'     => '/logos/crm.png',
                'primary_color' => '#0EA5E9',
                'theme'         => 'light',

                'is_active'     => false,

                'created_by'    => null,
                'updated_by'    => null,
            ],
        ]);
    }
}