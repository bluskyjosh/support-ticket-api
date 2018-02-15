<?php

use Illuminate\Database\Seeder;
use App\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Priority::create([
            'name' => 'Low',
            'description' => 'Non-breaking, non-pressing issue',
            'color' => '#24bc0d'
        ]);

        Priority::create([
            'name' => 'Medium',
            'description' => 'Pressing, possibly breaking issue with known workaround',
            'color' => '#fcf811'
        ]);

        Priority::create([
            'name' => 'High',
            'description' => 'Very pressing, breaking issue.',
            'color' => '#fc9d05'
        ]);

        Priority::create([
            'name' => 'Critical',
            'description' => 'Extremely pressing, systemic breaking issue',
            'color' => '#fc3a05'
        ]);

        Priority::create([
            'name' => 'Catastrophic',
            'description' => 'We\'re all going to die! AAAAAAAAAAAH!!!!',
            'color' => '#000000'
        ]);
    }
}
