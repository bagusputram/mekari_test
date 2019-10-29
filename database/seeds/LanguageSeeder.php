<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `languages` (`id`, `language_name`, `language_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'English', 'en', '2019-03-16 00:20:01', '2019-03-16 00:20:42', NULL),
            (2, 'Indonesian', 'id', '2019-03-16 00:21:01', '2019-03-16 00:21:07', NULL);
        "));
    }
}
