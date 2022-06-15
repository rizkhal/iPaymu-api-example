<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product;

class Payment extends Model
{
    use HasUuid;

    protected $table = 'payments';

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::PENDING());
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function detail(): HasOne
    {
        return $this->hasOne(PaymentDetail::class, 'payment_id', 'id');
    }
}
