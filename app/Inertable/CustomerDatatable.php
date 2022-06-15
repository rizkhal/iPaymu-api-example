<?php

declare(strict_types=1);

namespace App\Inertable;

use App\Models\Customer;
use Rizkhal\Inertable\Column;
use App\Inertable\Utils\Filter;
use Rizkhal\Inertable\Inertable;
use Illuminate\Database\Eloquent\Builder;

class CustomerDatatable extends Inertable
{
    public function query(): Builder
    {
        return Customer::query()
            ->when(!$this->hasSort(), function ($query) {
                return $query->orderBy('birth_date', 'desc');
            })
            ->when($this->getFilter('birth_date'), function ($query, $birthDate) {
                return $query->whereDate('birth_date', $birthDate);
            });
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')->sortable()->searchable(),
            Column::make(__('Job'), 'job')->sortable()->searchable(),
            Column::make(__('Birth Date'), 'birth_date')->sortable()->searchable()
                ->format(function ($row): array {
                    return [
                        'value' => $row->birth_date->format('d/m/Y'),
                        'hidden_value' => $row->birth_date,
                    ];
                }),
            Column::make(__('Date'), 'birth_date_odd_or_even'),
            Column::make(__('Week (Month)'), 'birth_date_week_odd_or_even'),
            Column::action(),
        ];
    }

    public function fields(): array
    {
        return [
            'birth_date' => Filter::make(__('Birth Date'))->date(),
        ];
    }
}
