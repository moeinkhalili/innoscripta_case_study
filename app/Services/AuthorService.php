<?php

namespace App\Services;

use App\Repositories\AuthorRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorService
{
    public function __construct(protected AuthorRepository $authorRepository) {}

    public function index(): LengthAwarePaginator
    {
        return $this->authorRepository->index();
    }
}
