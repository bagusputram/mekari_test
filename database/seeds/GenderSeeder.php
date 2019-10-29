<?php

use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `genders` (`id`, `gender_name`, `gender_language`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, 'Males', 'gender_male', '2019-03-14 11:47:15', '2019-03-24 09:48:59', NULL),
        (2, 'Female', 'gender_female', '2019-03-14 11:47:18', '2019-03-14 15:04:22', NULL);
        "));
    }
}
