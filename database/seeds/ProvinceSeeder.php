<?php

use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `provinces` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, 'Aceh', NULL, '2019-09-04 09:41:18', NULL),
        (2, 'Sumatera Utara', NULL, NULL, NULL),
        (3, 'Sumatera Barat', NULL, NULL, NULL),
        (4, 'Riau', NULL, NULL, NULL),
        (5, 'Jambi', NULL, NULL, NULL),
        (6, 'Sumatera Selatan', NULL, NULL, NULL),
        (7, 'Bengkulu', NULL, NULL, NULL),
        (8, 'Lampung', NULL, NULL, NULL),
        (9, 'Kepulauan Bangka Belitung', NULL, NULL, NULL),
        (10, 'Kepulauan Riau', NULL, NULL, NULL),
        (11, 'Dki Jakarta', NULL, NULL, NULL),
        (12, 'Jawa Barat', NULL, NULL, NULL),
        (13, 'Jawa Tengah', NULL, NULL, NULL),
        (14, 'Di Yogyakarta', NULL, NULL, NULL),
        (15, 'Jawa Timur', NULL, NULL, NULL),
        (16, 'Banten', NULL, NULL, NULL),
        (17, 'Bali', NULL, NULL, NULL),
        (18, 'Nusa Tenggara Barat', NULL, NULL, NULL),
        (19, 'Nusa Tenggara Timur', NULL, NULL, NULL),
        (20, 'Kalimantan Barat', NULL, NULL, NULL),
        (21, 'Kalimantan Tengah', NULL, NULL, NULL),
        (22, 'Kalimantan Selatan', NULL, NULL, NULL),
        (23, 'Kalimantan Timur', NULL, NULL, NULL),
        (24, 'Kalimantan Utara', NULL, NULL, NULL),
        (25, 'Sulawesi Utara', NULL, NULL, NULL),
        (26, 'Sulawesi Tengah', NULL, NULL, NULL),
        (27, 'Sulawesi Selatan', NULL, NULL, NULL),
        (28, 'Sulawesi Tenggara', NULL, NULL, NULL),
        (29, 'Gorontalo', NULL, NULL, NULL),
        (30, 'Sulawesi Barat', NULL, NULL, NULL),
        (31, 'Maluku', NULL, NULL, NULL),
        (32, 'Maluku Utara', NULL, NULL, NULL),
        (33, 'Papua Barat', NULL, NULL, NULL),
        (34, 'Papua', NULL, NULL, NULL);
        "));
    }
}
