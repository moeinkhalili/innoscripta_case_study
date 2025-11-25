<?php

namespace App\Repositories\Contracts;

use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

interface AuthorRepositoryInterface
{
    public function index(): LengthAwarePaginator;

    public function findById(int $id): ?Author;
}
