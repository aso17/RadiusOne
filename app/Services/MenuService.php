<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Repositories\MenuRepository;

class MenuService
{
    public static function getMenuByRole(int $roleId)
    {
        return Cache::remember(
            "menu_permission:role:{$roleId}",
            now()->addHours(1),
            function () use ($roleId) {

                $rows = MenuRepository::getByRole($roleId);

                $tree = [];

                foreach ($rows as $row) {

                    if (!$row->parent_id) {
                        $tree[$row->menu_id] ??= [
                            'id'       => $row->menu_id,
                            'code'     => $row->menu_code,
                            'name'     => $row->menu_name,
                            'icon'     => $row->icon,
                            'route'    => $row->route_name,
                            'children' => [],
                        ];
                    }

                    if ($row->sub_menu_id) {
                        $tree[$row->menu_id]['children'][] = [
                            'id'    => $row->sub_menu_id,
                            'code'  => $row->sub_menu_code,
                            'name'  => $row->sub_menu_name,
                            'route' => $row->sub_route,
                        ];
                    }
                }

                return array_values($tree);
            }
        );
    }
}
