<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Zone extends Model
{
    protected $fillable = ['zone_slug','zone_name','zone_status','zone_create_by','zone_update_by'];
    protected $guard = [];
    public function provinces(): hasMany
    {
        return $this->hasMany(Province::class,'zone_city','province_id');
    }

    public function cities(): belongsToMany
    {
        return $this->belongsToMany(City::class,'zone_city','city_id');
    }

    public function cityzones(): hasMany
    {
        return $this->hasMany(CityZone::class,['zone_id','province_id','city_id']);
    }
}
