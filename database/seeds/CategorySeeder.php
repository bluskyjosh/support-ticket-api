<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Category::create([
            'name' => 'Technical',
            'description' => 'Support ticket requires technician or engineer'
        ]);

        Category::create([
            'name' => 'Support',
            'description' => 'Support ticket is question about functionality'
        ]);

        Category::create([
            'name' => 'Bug',
            'description' => 'Support ticket is a possible bug report'
        ]);

        Category::create([
            'name' => 'Feature Request',
            'description' => 'Support ticket is a feature user suggests for system'
        ]);
    }
}
