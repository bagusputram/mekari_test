<?php

use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `user_profiles` (`id`, `user_id`, `application_language`, `application_theme_color`, `created_at`, `updated_at`, `deleted_at`, `profile_picture_id`) VALUES
            (1, 1, 1, 4, '2019-10-09 13:19:46', '2019-10-09 13:19:46', NULL, NULL);            
        "));
    }
}
