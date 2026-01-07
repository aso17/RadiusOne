<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Repositories\MenuRepository;

class MenuService
{
   public static function getMenuByRole(int $roleId)
{
    return Cache::remember("menu_permission:role:{$roleId}", 3600, function () use ($roleId) {
        $rows = MenuRepository::getByRole($roleId);

        $allMenus = [];
        $tree = [];

        // Gabungkan proses: Map data & susun tree dalam satu langkah jika memungkinkan
        foreach ($rows as $row) {
            $allMenus[$row->menu_id] = [
                'id'         => $row->menu_id,
                'name'       => $row->menu_name,
                'icon'       => $row->icon,
                'route'      => $row->route_name,
                'parent_id'  => $row->parent_id,
                'permissions'=> [
                    'view'   => (bool)$row->can_view,
                    'create' => (bool)$row->can_create,
                ],
                'children'   => []
            ];
        }

        foreach ($allMenus as $id => &$menu) {
            if ($menu['parent_id']) {
                if (isset($allMenus[$menu['parent_id']])) {
                    $allMenus[$menu['parent_id']]['children'][] = &$menu;
                }
            } else {
                $tree[] = &$menu;
            }
        }

        return $tree;
    });
}
}