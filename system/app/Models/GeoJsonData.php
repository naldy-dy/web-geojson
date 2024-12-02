<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoJsonData extends Model
{
    use HasFactory;

    protected $fillable = [
        'geojson', 
    ];

    protected $casts = [
        'geojson' => 'array', 
    ];
}
