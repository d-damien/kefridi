<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'Anaximandre',
                'email'     => 'contact@anaximandre.com',
                'password'  => '$2y$10$Ubp9XlIWU9/4JNZb46awAOAIrJrNf834W9O5hG8J1Kcb7/GKIdxoa'
            ],
            [
                'name'      => 'Test',
                'email'     => 'adresse@exemple.ndd',
                'password'  => '$2y$10$iXvvepmlHeSNIQ0DaXjqqu9BBNnHRw1W99oYRL2Xfpn3yBL/H/Efq'
            ]
        ]);
    }
}
