<?php

namespace App\Http\Controllers;

use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return inertia('products/index', [
            'filters' => fn () => $request->all(['category']),
            'products' => fn () => Product::query()
                ->when($request->get('category'), fn (Builder $query, $category) => $query->whereRelation('category', 'category_id', '=', $category))
                ->select(['id', 'name', 'image', 'qty', 'price', 'category_id'])->with('category')
                ->paginate(32),
        ])->title(__('Product Lists'));
    }
}
