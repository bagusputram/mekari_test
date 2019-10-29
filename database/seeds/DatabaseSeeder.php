<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            // Application Seeder
            ApplicationLanguageSeeder::class,
            ApplicationThemeColorsSeeder::class,
            SessionTimeoutSeeder::class,

            // Master Data Seeder
            CitizenshipSeeder::class,
            GenderSeeder::class,
            LanguageSeeder::class,

            // Menu Seeder
            MenuSeeder::class,
            TodoListMenu::class,
            MenuTypeSeeder::class,

            // Route Seeder
            RouteControllerTypeSeeder::class,
            RouteTypeSeeder::class,
            RouteListSeeder::class,

            // User Seeder
            UserRoleSeeder::class,
            UserMenuPermissionSeeder::class,
            UserSeeder::class,
            UserProfileSeeder::class,

            // Province and Child
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            SubdistrictSeeder::class,
            SubdistrictSeederv1::class,
            SubdistrictSeederv2::class,
            SubdistrictSeederv3::class,
            SubdistrictSeederv4::class,
            SubdistrictSeederv5::class,
            SubdistrictSeederv6::class,
            SubdistrictSeederv7::class,
            SubdistrictSeederv8::class,

            TodoListRouteListSeeder::class,
            ToDoListRouteApiSeeder::class,

        ]);
    }
}
