<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityZone extends Model
{
    protected $fillable = ['zone_id', 'province_id', 'city_id'];
    protected $table = 'zone_city';
    protected $guard = [];

    public function zones()
    {
        return $this->belongsToMany(CityZone::class, 'zone_id');
    }

    public function provinces()  
    {
        return $this->belongsToMany(CityZone::class, 'province_id');
    }

    public function cities()
    {
        return $this->belongsToMany(CityZone::class, 'city_id');
    }

}
