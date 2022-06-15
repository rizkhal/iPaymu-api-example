<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class Qty implements Rule
{
    public function __construct(
        private readonly int $qty
    ) {
        // 
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (int)$this->qty >= (int)$value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Qty not enough, must be less than or equal to {$this->qty}";
    }
}
