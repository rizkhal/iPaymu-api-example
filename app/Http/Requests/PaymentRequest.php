<?php

namespace App\Http\Requests;

use App\Rules\Qty;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'qty' => ['required', 'numeric', new Qty(Product::find($this->id)->qty)],
        ];
    }

    public function getData(): array
    {
        return [
            'product' => [$this->name],
            'qty' => [$this->qty],
            'price' => [$this->price],
            'returnUrl' => route('product.index'),
            'cancelUrl' => route('product.index'),
            'notifyUrl' => env('I_PAYMU_WEBHOOK_URL'),
        ];
    }
}
