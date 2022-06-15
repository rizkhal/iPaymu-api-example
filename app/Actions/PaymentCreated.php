<?php

namespace App\Actions;

use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class PaymentCreated
{
    public static function handle(PaymentRequest $request, object $apiResponse)
    {
        return DB::transaction(function () use ($request, $apiResponse) {
            Payment::create([
                'product_id' => $request->id,
                'user_id' => $request->user()->id,
                'qty' => $request->qty,
                'status' => PaymentStatus::CREATED(),
                'ipaymu_session_id' => $apiResponse->Data->SessionID,
                'ipaymu_session_url' => $apiResponse->Data->Url,
            ]);

            // ...
        });
    }
}
