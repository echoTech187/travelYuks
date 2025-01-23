<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['province_name', 'province_slug', 'province_status', 'province_create_by', 'province_update_by'];
    protected $guard = [];

   
    public function cities(): hasMany
    {
        return $this->hasMany(City::class);
    }
    
}
