<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('application_languages')->insert(
            [
                'language' => 1,
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ]
        );
    }
}
