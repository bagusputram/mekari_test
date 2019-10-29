<?php

use Illuminate\Database\Seeder;

class RouteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `route_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'get', '2019-03-18 19:10:35', '2019-03-18 12:14:41', NULL),
            (2, 'post', '2019-03-18 01:51:43', '2019-03-18 01:51:43', NULL),
            (3, 'put', '2019-03-18 01:51:49', '2019-03-18 01:51:49', NULL),
            (4, 'patch', '2019-03-18 01:51:52', '2019-03-18 01:51:52', NULL),
            (5, 'delete', '2019-03-18 01:51:55', '2019-03-18 01:51:55', NULL),
            (6, 'option', '2019-03-18 14:14:29', '2019-03-18 14:14:30', NULL);
        "));
    }
}
