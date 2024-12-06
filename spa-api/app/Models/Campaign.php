<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_group_id', 'is_active', 'discount_value', 'discount_percentage'];

    public function cityGroup()
    {
        return $this->belongsTo(CityGroup::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
