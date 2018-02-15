<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Category::truncate();
        \App\Priority::truncate();
        \App\Status::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $this->call(CategorySeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(StatusSeeder::class);


    }
}
