<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function __construct(protected AuthorService $authorService) {}

    public function index(): AnonymousResourceCollection
    {
        return AuthorResource::collection(
            $this->authorService->index()
        );
    }

    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author);
    }
}
