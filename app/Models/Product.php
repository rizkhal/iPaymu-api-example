<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasUuid,
        HasFactory;

    protected $guarded = [];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'product_id');
    }
}
