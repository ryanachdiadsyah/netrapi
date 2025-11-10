<?php

namespace Database\Seeders;

use App\Models\EventList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventHarlahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // `event_type`, `event_name`, `event_slug`, `event_description`, `event_from_date`, `event_to_date`, `event_location`, `event_thumbnail`, `frequency`, `band`, `mode`, `organizer_name`, `organizer_callsign`, `organizer_email`, `organizer_phone`, `certificate_background`, `certificate_design_options`, `created_by`, `updated_by`, `is_published`
        EventList::create([
            'event_type' => 'special_event',
            'event_name' => 'Harlah RAPI ke-45',
            'event_slug' => 'harlah-rapi-ke-45',
            'event_description' => 'Perayaan Hari Lahir RAPI yang ke-45 tahun.',
            'event_from_date' => '2025-11-10',
            'event_to_date' => '2025-11-30',
            'event_location' => 'Banda Aceh',
            'event_thumbnail' => '#',
            'frequency' => json_encode(['143.480']),
            'band' => json_encode(['2m']),
            'mode' => json_encode(['fm']),
            'organizer_name' => 'RAPI Banda Aceh',
            'organizer_callsign' => 'ZWA',
            'organizer_email' => 'rapibna@gmail.com',
            'organizer_phone' => '081263280610',
            'certificate_background' => 'harlah45.jpeg',
            'certificate_design_options' => NULL,
            'created_by' => 2,
            'updated_by' => 2,
            'is_published' => true,
        ]);
    }
}
