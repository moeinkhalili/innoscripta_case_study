<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository) {}

    public function index(): LengthAwarePaginator
    {
        return $this->categoryRepository->index();
    }
}
