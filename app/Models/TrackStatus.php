<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackStatus extends Model
{
    use HasFactory, Compoships;

    protected $table = 'track_status';
}
