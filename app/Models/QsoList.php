<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QsoList extends Model
{
    protected $fillable = [
        'event_id',
        'callsign',
        'qso_date',
        'frequency',
        'band',
        'mode',
        'rst_sent',
        'rst_received',
        'operator_callsign',
        'uploaded_by',
    ];
}
