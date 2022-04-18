<?php

namespace Database\Seeders\Demo;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventType::create([
            'label' => 'Concert',
            'Description' => 'Événement regroupant plusieurs personnes dans un endroit pour écouter de la music'
        ]);
        EventType::create([
            'label' => 'Festival',
            'Description' => ' '
        ]);
        EventType::create([
            'label' => 'Conference',
            'Description' => ' '
        ]);
        EventType::create([
            'label' => 'Séminaire',
            'Description' => ' '
        ]);
        EventType::create([
            'label' => 'Èvénement sportif',
            'Description' => ' '
        ]);
        EventType::create([
            'label' => 'salon ou exposition',
            'Description' => ' '
        ]);
    }
}
