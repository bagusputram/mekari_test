<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `user_roles` (`id`, `user_role_name`, `description`, `user_role_bypass`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'System Admin', 'Highest User Role for Application', '1', '2019-03-14 04:48:54', '2019-03-14 09:28:11', NULL),
            (2, 'Administrator', 'Administrator', 1, '2019-10-18 13:16:58', '2019-10-18 13:16:58', NULL);
        "));
    }
}
