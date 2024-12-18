<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state_id', 'city_group_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cityGroup()
    {
        return $this->belongsTo(CityGroup::class);
    }
    
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
