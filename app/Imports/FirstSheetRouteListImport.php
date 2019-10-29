<?php

namespace App\Imports;

use App\Models\Setting\Menu;
use App\Models\Setting\MenuType;
use App\Models\Setting\RouteControllerType;
use App\Models\Setting\RouteList;
use App\Models\Setting\RouteType;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class FirstSheetRouteListImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        $row['route_type_id']               = RouteType::where('name', $row['route_type_id'])->first()->id;
        $row['route_controller_type_id']    = RouteControllerType::where('name', $row['route_controller_type_id'])->first()->id;
        $row['menu_type_id']                = MenuType::where('name', $row['menu_type_id'])->first()->id;
        $row['menu_id']                     = Menu::where('menu_name', $row['menu_id'])->first()->id;

        return new RouteList([
            'name'                          => $row['name'],
            'route_type_id'                 => $row['route_type_id'],
            'route_controller_type_id'      => $row['route_controller_type_id'],
            'route_controller_name'         => $row['route_controller_name'],
            'route_menu_name'               => $row['route_menu_name'],
            'menu_type_id'                  => $row['menu_type_id'],
            'menu_id'                       => $row['menu_id'],
            'route_link'                    => $row['route_link'],
        ]);        
    }

    
}
