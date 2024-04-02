<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];
}
