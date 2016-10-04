<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\User::class, 2)->create();
        factory(App\Journal::class, 55)->create();
    }
}
