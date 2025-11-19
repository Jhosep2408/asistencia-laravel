<?php
// app/Models/Holiday.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'reason',
        'description',
        'no_classes'
    ];

    protected $casts = [
        'date' => 'date',
        'no_classes' => 'boolean'
    ];
}