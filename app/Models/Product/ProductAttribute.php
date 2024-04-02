<?php

namespace App\Models\Product;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProductAttribute extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'store_id',
        'slug',
        'name',
        'description',
        'terms',
    ];

    protected $casts = [
        'terms' => 'array',
    ];

    public function buildSortQuery()
    {
        return static::query()->where('store_id', $this->store_id);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
            ->extraScope(fn ($builder) => $builder->where('store_id', $this->store_id));
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
