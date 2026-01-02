<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class ProjectInfoController extends Controller
{
    public function show(Request $request)
    {
        $domain = $request->getHost();
       
        $tenant = Tenant::where('domain', $domain)
            ->where('is_active', true)
            ->first();

        if (!$tenant) {
            return response()->json([
                'message' => 'Tenant not found or inactive'
            ], 404);
        }

        return response()->json([
            'name'          => $tenant->tenant_name,
            'logo_url'      => $tenant->logo_path
                                ? asset("storage/{$tenant->logo_path}")
                                : null,
            'primary_color' => $tenant->primary_color,
            'theme'         => $tenant->theme,
        ]);

    }
}
