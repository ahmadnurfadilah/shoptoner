<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUser extends Pivot
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'user_id',
    ];
}
