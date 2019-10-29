<?php

use Illuminate\Database\Seeder;

class TodoListMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert(
            [
            'menu_name' => 'To Do List',
            'menu_icon' => 'fa fa-tasks',
            'menu_language' => 'to-do-list',
            'menu_controller' => 'to-do-list',
            'menu_position' => '2',
            'menu_parent_id' => '0',
            'user_role_id' => '["1","2"]',
            'created_at' => DB::raw('now()'),
            'updated_at' => DB::raw('now()'),
            ]
        );
    }
}
