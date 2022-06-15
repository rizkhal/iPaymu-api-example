<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\Ipaymu;
use App\Actions\PaymentCreated;
use App\Actions\PaymentConfirmed;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function index()
    {
        return inertia('payments/index')->title(__('Payment'));
    }

    public function history()
    {
        return inertia('payments/history', [
            'histories' => fn () => Payment::with('detail')->whereIn('status', [PaymentStatus::COMPLETE(), PaymentStatus::FAILED()])->get(),
        ])->title(__('History'));
    }

    public function redirect(PaymentRequest $request)
    {
        try {
            $response = Ipaymu::createPayment($request->getData());
            $object = $response->object();

            if ($response->status() === Response::HTTP_BAD_REQUEST) {
                return back()->error($object->Message);
            }

            if ($response->serverError()) {
                return back()->error(__("Something went wrong, server can't response"));
            }

            PaymentCreated::handle($request, $object);

            Log::info('payment created', [
                'response' => $object,
                'user' => $request->user(),
            ]);

            return Inertia::location($object->Data->Url);
        } catch (\Throwable $th) {
            return back()->error($th->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        try {
            PaymentConfirmed::handle($request);

            return response()->json([
                'success' => true,
                'message' => Response::$statusTexts[Response::HTTP_OK],
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('webhook error', ['line' => $th->getLine(), 'message' => $th->getMessage()]);
            return response()->json(['success' => false, 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
