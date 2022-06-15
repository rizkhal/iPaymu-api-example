<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke(Request $request)
    {
        return CategoryResource::collection(
            Category::query()->where('name', 'like', '%' . $request->query('q') . '%')->paginate(10)
        );
    }
}
