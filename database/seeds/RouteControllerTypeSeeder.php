<?php

use Illuminate\Database\Seeder;

class RouteControllerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `route_controller_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'web', '2019-03-18 02:36:25', '2019-03-18 02:37:43', NULL),
            (2, 'api', '2019-03-18 02:37:38', '2019-03-18 02:37:38', NULL);
        "));
    }
}
