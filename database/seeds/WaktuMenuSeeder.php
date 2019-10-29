<?php

use Illuminate\Database\Seeder;

class WaktuMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert(
            [
                'menu_name' => 'Waktu',
                'menu_icon' => 'fa fa-database',
                'menu_language' => 'waktu',
                'menu_controller' => 'data-master/waktu',
                'menu_position' => '9',
                'menu_parent_id' => '19',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ]
        );
    }
}
