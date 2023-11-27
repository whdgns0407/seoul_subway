<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'station_name',
        'line_id',
        'statn_id',
        'created_at',
        'updated_at'
    ];
}
