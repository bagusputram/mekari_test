<?php

use Illuminate\Database\Seeder;

class WaktuApiRouteSeeder extends Seeder
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
                'name' => 'Waktu Api All Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Eperformance\DataMaster\Api\WaktuController',
                'route_menu_name' => 'api.eperformance.data-master.waktu.all',
                'menu_type_id' => 1,
                'menu_id' => 28,
                'route_link' => 'eperformance/data-master/waktu/alldata/{trash}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'Waktu Api Single Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Eperformance\DataMaster\Api\WaktuController',
                'route_menu_name' => 'api.eperformance.data-master.waktu.id',
                'menu_type_id' => 1,
                'menu_id' => 28,
                'route_link' => 'eperformance/data-master/waktu/singledata/{id}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
        ]);
    }
}
