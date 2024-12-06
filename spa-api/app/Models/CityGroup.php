<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class)->where('is_active', true);
    }
}
