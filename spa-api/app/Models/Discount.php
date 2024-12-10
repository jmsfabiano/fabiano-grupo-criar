<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id', 
        'type', 
        'percentage_discount', 
        'value_discount',
        'minimum_value'
    ];
    
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_VALUE = 'value';

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}