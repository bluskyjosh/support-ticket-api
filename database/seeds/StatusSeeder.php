<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Status::create([
            'name' => 'Open',
            'description' => 'New/open support ticket',
            'color' => '#66a7e8'
        ]);

        Status::create([
            'name' => 'In Progress',
            'description' => 'Ticket is currently being addressed by staff.',
            'color' => '#64f42b'
        ]);

        Status::create([
            'name' => 'Waiting for Input',
            'description' => 'Additional input from the original poster is required.',
            'color' => '#f2ff07'
        ]);

        Status::create([
            'name' => 'Closed',
            'description' => 'Support ticket has been resolved.',
            'color' => '#f42c2c'
        ]);


    }

}
