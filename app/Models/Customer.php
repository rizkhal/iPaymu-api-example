<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasUuid;
use Illuminate\Support\Carbon;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasUuid,
        HasFactory;

    protected $table = 'customers';

    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function (self $model) {
            // > b. Pada saat insert data, generate key di database dengan menggunakan format UUID
            $model->fill(['uuid_key' => Str::uuid()]);
        });
    }

    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }

    protected function parseBirthDate(): Carbon
    {
        return Carbon::parse($this->birth_date);
    }

    protected function getDate($format): string
    {
        return $this->parseBirthDate()->format($format);
    }

    protected function getWeek()
    {
        return $this->parseBirthDate()->weekOfMonth;
    }

    public function birthDateWeekOddOrEven(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getWeek() % 2 == 0 ? __('Genap') : __('Ganjil'),
        );
    }

    public function birthDateOddOrEven(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getDate('d') % 2 == 0 ? __('Genap') : __('Ganjil'),
        );
    }
}
