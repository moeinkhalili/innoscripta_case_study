<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            $this->categoryService->index()
        );
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
