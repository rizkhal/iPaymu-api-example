<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasUuid,
        SoftDeletes;

    protected $table = 'categories';

    protected $guarded = [];

    public function scopeWhereLike(Builder $query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }
}
