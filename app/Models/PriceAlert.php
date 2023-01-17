<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'symbol', 'price_min', 'notified'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'notified' => 'boolean',
    ];
}
