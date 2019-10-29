<?php

use Illuminate\Database\Seeder;

class UnitKerjaApiRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('route_lists')->insert([
            [
                'name' => 'Unit Kerja Api All Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Eperformance\DataMaster\Api\UnitKerjaController',
                'route_menu_name' => 'api.eperformance.data-master.unit-kerja.all',
                'menu_type_id' => 1,
                'menu_id' => 20,
                'route_link' => 'eperformance/data-master/unit-kerja/alldata/{trash}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'Unit Kerja Api Single Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Eperformance\DataMaster\Api\UnitKerjaController',
                'route_menu_name' => 'api.eperformance.data-master.unit-kerja.id',
                'menu_type_id' => 1,
                'menu_id' => 20,
                'route_link' => 'eperformance/data-master/unit-kerja/singledata/{id}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
        ]);
    }
}
