<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function index(): LengthAwarePaginator;

    public function findById(int $id): ?Category;
}
