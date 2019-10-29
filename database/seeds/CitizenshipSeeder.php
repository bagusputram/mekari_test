<?php

use Illuminate\Database\Seeder;

class CitizenshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `citizenships` (`id`, `citizenship_name`, `citizenship_label`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, 'Warga Negara Indonesiaa', 'wni', '2019-03-14 08:08:42', '2019-03-15 04:15:15', NULL),
        (3, 'Korea', 'KOR', '2019-03-14 08:54:25', '2019-03-14 08:56:22', '2019-03-14 08:56:22'),
        (4, 'Warga Negara Asing', 'WNA', '2019-03-15 04:17:17', '2019-03-15 04:17:17', NULL);
        "));
    }
}
