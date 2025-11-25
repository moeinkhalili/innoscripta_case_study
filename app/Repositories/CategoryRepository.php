<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        return Category::query()->paginate();
    }

    public function findById(int $id): ?Category
    {
        return Category::query()->find($id);
    }
}
