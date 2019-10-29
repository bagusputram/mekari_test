<?php

use Illuminate\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `menu_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (1, 'index', '2019-03-18 02:11:28', '2019-03-18 02:12:00', NULL),
            (2, 'create', '2019-03-18 02:11:33', '2019-03-18 02:11:33', NULL),
            (3, 'edit', '2019-03-18 02:11:41', '2019-03-18 07:50:08', NULL),
            (4, 'store', '2019-03-18 02:11:46', '2019-03-18 07:50:16', NULL),
            (5, 'update', '2019-03-18 02:12:14', '2019-03-18 07:50:22', NULL),
            (6, 'delete', '2019-03-18 02:12:18', '2019-03-18 07:50:33', NULL),
            (7, 'import', '2019-03-18 02:12:21', '2019-03-18 07:51:11', NULL),
            (8, 'export', '2019-03-18 02:12:24', '2019-03-18 07:51:17', NULL),
            (9, 'destroy', '2019-03-18 02:14:48', '2019-03-18 07:51:22', NULL),
            (10, 'restore', '2019-03-18 07:22:54', '2019-03-18 07:51:29', NULL),
            (11, 'copy', '2019-03-18 08:22:39', '2019-03-18 08:28:08', NULL);
        "));
    }
}
