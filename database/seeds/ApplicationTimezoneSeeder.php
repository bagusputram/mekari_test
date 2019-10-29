<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationTimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `application_timezones` (`id`, `timezone`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Asia/Jakarta', '2019-03-16 10:22:50', '2019-03-16 11:13:35', NULL)"));

    }
}
