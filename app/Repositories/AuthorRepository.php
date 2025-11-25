<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        return Author::query()->paginate();
    }

    public function findById(int $id): ?Author
    {
        return Author::query()->find($id);
    }
}
