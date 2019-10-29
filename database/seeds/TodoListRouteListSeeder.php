<?php

use Illuminate\Database\Seeder;

class TodoListRouteListSeeder extends Seeder
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
                'name' => 'To Do List Index',
                'route_type_id' => 1,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.index',
                'menu_type_id' => 1,
                'menu_id' => 19,
                'route_link' => 'to-do-list',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Create',
                'route_type_id' => 1,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.create',
                'menu_type_id' => 2,
                'menu_id' => 19,
                'route_link' => 'to-do-list/create',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Edit',
                'route_type_id' => 1,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.edit',
                'menu_type_id' => 3,
                'menu_id' => 19,
                'route_link' => 'to-do-list/{id}/edit',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Store',
                'route_type_id' => 2,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.store',
                'menu_type_id' => 4,
                'menu_id' => 19,
                'route_link' => 'to-do-list',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Update',
                'route_type_id' => 3,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.update',
                'menu_type_id' => 5,
                'menu_id' => 19,
                'route_link' => 'to-do-list/{id}/edit',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Delete',
                'route_type_id' => 4,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.delete',
                'menu_type_id' => 6,
                'menu_id' => 19,
                'route_link' => 'to-do-list/{id}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Import',
                'route_type_id' => 2,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.import',
                'menu_type_id' => 7,
                'menu_id' => 19,
                'route_link' => 'to-do-list/import',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Export',
                'route_type_id' => 1,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.export',
                'menu_type_id' => 8,
                'menu_id' => 19,
                'route_link' => 'to-do-list/export',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Destroy',
                'route_type_id' => 5,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.destroy',
                'menu_type_id' => 9,
                'menu_id' => 19,
                'route_link' => 'to-do-list/{id}',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
            [
                'name' => 'To Do List Restore',
                'route_type_id' => 2,
                'route_controller_type_id' => 1,
                'route_controller_name' => 'ToDoListController',
                'route_menu_name' => 'to-do-list.restore',
                'menu_type_id' => 10,
                'menu_id' => 19,
                'route_link' => 'to-do-list/{id}/restore',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ],
        ]);
    }
}
