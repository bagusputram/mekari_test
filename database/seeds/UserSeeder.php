<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert(DB::raw("INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `auth_last_login`, `password`, `user_role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
            (1, 'Bagus Putra M', 'baguspm', 'bagus.pm29@gmail.com', '2019-03-16 08:35:42', '2019-10-09 10:44:44', '$2y$10$19aPyP1BMO8mEsL0TJYyqOcpqWe0JjWm1T.Tj/t92P./Nsk38X1oK', 1, 'JWvI8UJOI90CTP2iB1ZlgC8mrmHk6rjdfMdOF59IUy72gcoV1tknojr993KY', '2019-03-16 09:06:45', '2019-10-09 10:44:44');
        "));
    }
}
