<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'total', 'discount_applied'];
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot('quantity');
    }
}
