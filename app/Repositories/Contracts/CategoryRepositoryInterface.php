<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function index(): LengthAwarePaginator;
}
