<?php

use Illuminate\Database\Seeder;

class ToDoListRouteApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('route_lists')->insert([
            [
                'name' => 'To Do List Api All Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Api\ToDoListController',
                'route_menu_name' => 'api.to-do-list.all',
                'menu_type_id' => 1,
                'menu_id' => 19,
                'route_link' => 'to-do-list/alldata/{trash}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Api Single Data',
                'route_type_id' => 1,
                'route_controller_type_id' => 2,
                'route_controller_name' => 'Api\ToDoListController',
                'route_menu_name' => 'api.to-do-list.id',
                'menu_type_id' => 1,
                'menu_id' => 19,
                'route_link' => 'to-do-list/singledata/{id}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
        ]);
    }
}
