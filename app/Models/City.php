<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class City extends Model
{
    protected $fillable = ['province_id', 'city_name', 'city_slug', 'city_status', 'city_create_by', 'city_update_by'];
    protected $guard = [];

    public function province(): hasMany
    {
        return $this->hasMany(Province::class);
    }
    public function zone(): hasMany
    {
        return $this->hasMany(Zone::class);
    }
    
}
