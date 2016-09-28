<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = factory(App\User::class, 2)->create()
            ->each(function ($u) {
                $u->journals()->save(factory(App\Journal::class)->make());
            });
    }
}
