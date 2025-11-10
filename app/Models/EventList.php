<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventList extends Model
{
    // `event_type`, `event_name`, `event_slug`, `event_description`, `event_from_date`, `event_to_date`, `event_location`, `event_thumbnail`, `frequency`, `band`, `mode`, `organizer_name`, `organizer_callsign`, `organizer_email`, `organizer_phone`, `certificate_background`, `certificate_design_options`, `created_by`, `updated_by`, `is_published`
    protected $fillable = [
        'event_type',
        'event_name',
        'event_slug',
        'event_description',
        'event_from_date',
        'event_to_date',
        'event_location',
        'event_thumbnail',
        'frequency',
        'band',
        'mode',
        'organizer_name',
        'organizer_callsign',
        'organizer_email',
        'organizer_phone',
        'certificate_background',
        'certificate_design_options',
        'created_by',
        'updated_by',
        'is_published',
    ];
}
