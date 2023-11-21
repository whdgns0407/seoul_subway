<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'line_code',
        'line_name',
    ];
}
