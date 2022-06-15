<?php

namespace App\Providers;

use Rizkhal\Inertable\Inertable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Inertia\Response as InertiaResponse;

class MacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCustomInertiaProps();
        $this->registeCustomRizkhalInertableProps();
    }

    public function registerCustomInertiaProps(): void
    {
        InertiaResponse::macro('title', function ($title) {
            return $this->with('title', $title);
        });

        RedirectResponse::macro('success', function (string $message) {
            $this->with(['success' => $message]);

            return $this;
        });

        RedirectResponse::macro('error', function (string $message) {
            $this->with(['error' => $message]);

            return $this;
        });
    }

    public function registeCustomRizkhalInertableProps(): void
    {
        InertiaResponse::macro('datatable', function (Inertable $datatable) {
            $this->with([
                'datatable' => [
                    'fields' => $datatable->fields(),
                    'columns' => $datatable->columns(),
                    'data' => $datatable->applyInertable(request()),
                    'filters' => request()->all(['column', 'search', 'direction', 'filters', 'perpage']),
                ],
            ]);

            return $this;
        });
    }
}
