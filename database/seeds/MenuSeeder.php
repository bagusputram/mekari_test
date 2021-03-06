<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert([
            [
                'id'        => 1,
                'menu_name' => 'Dashboard',
                'menu_icon' => 'fa fa-home',
                'menu_language' => 'dashboard',
                'menu_controller' => 'home',
                'menu_position' => '1',
                'menu_parent_id' => '0',
                'user_role_id' => '["1"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 2,
                'menu_name' => 'Manage Setting',
                'menu_icon' => 'fa fa-gear',
                'menu_language' => 'manage_setting',
                'menu_controller' => 'setting',
                'menu_position' => '6',
                'menu_parent_id' => '0',
                'user_role_id' => '[]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 10,
                'menu_name' => 'Restricted Setting',
                'menu_icon' => 'fa-fa-x',
                'menu_language' => 'restricted_setting',
                'menu_controller' => 'setting/restricted-setting',
                'menu_position' => '4',
                'menu_parent_id' => '2',
                'user_role_id' => '["1"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 11,
                'menu_name' => 'Master Data Setting',
                'menu_icon' => 'fa fa-gear',
                'menu_language' => 'master-data-setting',
                'menu_controller' => 'setting/master-data-setting',
                'menu_position' => '3',
                'menu_parent_id' => '2',
                'user_role_id' => '["1"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 12,
                'menu_name' => 'User Application',
                'menu_icon' => 'fa fa-user',
                'menu_language' => 'user_application',
                'menu_controller' => 'setting/user-application-profile',
                'menu_position' => '2',
                'menu_parent_id' => '2',
                'user_role_id' => '["1"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 13,
                'menu_name' => 'Setting User Data Authentication',
                'menu_icon' => 'fa fa-user',
                'menu_language' => 'edit_user_data_authentication',
                'menu_controller' => 'setting/edit-user-data-authentication',
                'menu_position' => '1',
                'menu_parent_id' => '2',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,                
            ],
            [
                'id'        => 14,
                'menu_name' => 'User Management',
                'menu_icon' => 'fa fa-user',
                'menu_language' => 'user_management',
                'menu_controller' => 'user-management',
                'menu_position' => '5',
                'menu_parent_id' => '0',
                'user_role_id' => '[]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => NULL,
            ],
            [
                'id'        => 15,
                'menu_name' => 'Inventory',
                'menu_icon' => 'fa fa-archive',
                'menu_language' => 'inventory',
                'menu_controller' => 'inventory',
                'menu_position' => '3',
                'menu_parent_id' => '0',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => DB::raw('now()'),
            ],
            [
                'id'        => 16,
                'menu_name' => 'Company Information',
                'menu_icon' => 'fa fa-building',
                'menu_language' => 'company_information',
                'menu_controller' => 'company-information',
                'menu_position' => '4',
                'menu_parent_id' => '0',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),     
                'deleted_at' => DB::raw('now()'),
            ],
            [
                'id'        => 17,
                'menu_name' => 'Band',
                'menu_icon' => 'fa fa-headphones',
                'menu_language' => 'band',
                'menu_controller' => 'band',
                'menu_position' => '2',
                'menu_parent_id' => '0',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => DB::raw('now()'),
            ],
            [
                'id'        => 18,
                'menu_name' => 'Event',
                'menu_icon' => 'fa fa-calendar',
                'menu_language' => 'event',
                'menu_controller' => 'event',
                'menu_position' => '3',
                'menu_parent_id' => '0',
                'user_role_id' => '["1","2"]',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
                'deleted_at' => DB::raw('now()'),
            ],
        ]);
    }
}
