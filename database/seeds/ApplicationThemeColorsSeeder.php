<?php

use Illuminate\Database\Seeder;

class ApplicationThemeColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        
        DB::insert(DB::raw("INSERT INTO `application_theme_colors` (`id`, `name`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, 'Red', 'skin-red', '2019-03-25 15:06:15', '2019-03-25 15:06:15', NULL),
        (2, 'Blue', 'skin-blue', '2019-03-25 15:15:26', '2019-03-25 15:15:26', NULL),
        (3, 'Green', 'skin-green', '2019-03-25 16:22:52', '2019-03-25 16:22:52', NULL),
        (4, 'Black', 'skin-black', '2019-03-25 16:23:02', '2019-03-25 16:23:02', NULL),
        (5, 'Purple', 'skin-purple', '2019-03-25 16:23:09', '2019-03-25 16:23:09', NULL),
        (6, 'yellow', 'skin-yellow', '2019-03-25 16:23:25', '2019-03-25 16:23:25', NULL);"));
    }
}