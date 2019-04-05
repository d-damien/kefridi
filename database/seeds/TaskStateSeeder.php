<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_states')->insert([
            ['name' => 'todo'],
            ['name' => 'ongoing'],
            ['name' => 'done'],
        ]);
    }
}
