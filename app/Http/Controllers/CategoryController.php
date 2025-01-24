<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\Category;
use App\Core\Infra\CategoryRepositoryInDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate(['name' => 'required|string|unique:category']);

        //1 ICP - Acoplamento contextual
        $category = new Category($validatedRequest['name']);

        //1 ICP - Acoplamento Contextual
        $repository = new CategoryRepositoryInDatabase();

        $id = $repository->store($category);
        $category->setId($id);

        return response()->json($category->toArray());
    }
}
