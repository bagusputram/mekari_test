<?php

use Illuminate\Database\Seeder;

class SessionTimeoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `session_timeouts` (`id`, `session_timeout`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 0, '2019-03-15 12:40:15', '2019-09-04 09:49:36', NULL);
        "));
    }
}
