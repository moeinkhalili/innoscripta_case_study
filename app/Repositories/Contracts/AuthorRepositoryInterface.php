<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface AuthorRepositoryInterface
{
    public function index(): LengthAwarePaginator;
}
