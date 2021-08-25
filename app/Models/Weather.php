<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weathers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weather_main',
        'weather_description',
        'weather_icon',
        'main_temp',
        'main_feels_like',
        'main_temp_min',
        'main_temp_max',
        'main_pressure',
        'main_humidity',
        'visibility',
        'wind_speed',
        'wind_deg',
        'clouds_all',
        'time_of_data_calculation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    /**
     * Get the post that owns the comment.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
