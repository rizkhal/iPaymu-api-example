<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasUuid;

    protected $table = 'payment_details';

    protected $guarded = [];
}
