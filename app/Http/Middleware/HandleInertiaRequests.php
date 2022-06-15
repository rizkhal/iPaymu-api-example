<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'payments' => static::handlePayments(),
            'auth' => fn () => $request->user() ? $request->user() : null,
            'flash' => fn (): array => [
                'error' => $request->session()->get('error'),
                'success' => $request->session()->get('success'),
            ],
        ]);
    }

    public static function handlePayments(): Collection
    {
        if (auth()->check()) {
            return Payment::query()->with('detail')->pending()->where('user_id', auth()->user()->id)->get();
        }

        return collect();
    }
}
