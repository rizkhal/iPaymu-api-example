<?php

namespace App\Actions;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentConfirmed
{
    public static function handle(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $payment = Payment::where('ipaymu_session_id', $request->sid)->first();

            switch ((int)$request->status_code) {
                case PaymentStatus::PENDING():
                    $payment->update(['status' => PaymentStatus::PENDING()]);

                    $payment->detail()->create([
                        'trx_id' => $request->trx_id,
                        'data' => json_encode([PaymentStatus::PENDING->name => $request->all()]),
                    ]);
                    break;
                case PaymentStatus::COMPLETE():
                    $payment->update(['status' => PaymentStatus::COMPLETE()]);

                    $payment->detail->update([
                        'trx_id' => $request->trx_id,
                        'data' => array_merge([PaymentStatus::COMPLETE->name => $request->all()], (array)json_decode($payment->detail->data)),
                    ]);

                    $payment->product->update([
                        'qty' => (int)$payment->product->qty - (int)$payment->qty
                    ]);
                    break;
                case PaymentStatus::FAILED():
                    $payment->update(['status' => PaymentStatus::FAILED()]);

                    $payment->detail->update([
                        'trx_id' => $request->trx_id,
                        'data' => array_merge([PaymentStatus::COMPLETE->name => $request->all()], (array)json_decode($payment->detail->data)),
                    ]);
                    break;
            }
        });
    }
}
