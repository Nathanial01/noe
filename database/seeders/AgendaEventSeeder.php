<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgendaEvent;

class AgendaEventSeeder extends Seeder
{
    public function run()
    {
        $events = [
//            [
//                'title'       => 'Rotterdam Masterclass Huurprijscheck.app 2025',
//                'start_dateTime'  => '2025-02-06',
//                'end_dateTime'    => '2025-02-06',
//                'place'       => 'Amsterdam',
//                'location'    => 'Maaskade 111b, 3071 NJ, Rotterdam, Nederland',
//                'description' => 'Leer alles over de nieuwste regelgeving!',
//                'cancelled'   => false,
//            ],

        ];

        foreach ($events as $event) {
            AgendaEvent::create($event);
        }
    }
}
