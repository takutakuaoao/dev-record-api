<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DevRecord\Application\Category\Delete\CategoryDeleteRequest;
use DevRecord\Application\Category\Delete\CategoryDeleteUseCase;
use DevRecord\Application\Category\Edit\CategoryEditRequest;
use DevRecord\Application\Category\Edit\CategoryEditUseCase;
use DevRecord\Application\Category\Find\CategoryFindRequest;
use DevRecord\Application\Category\Find\CategoryFindUseCase;
use DevRecord\Application\Category\Index\CategoryIndexUseCase;
use DevRecord\Application\Category\Store\CategoryStoreRequest;
use DevRecord\Application\Category\Store\CategoryStoreUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(CategoryIndexUseCase $useCase)
    {
        $response = $useCase->execute();

        return [
            'result' => true,
            'data'   => $response->toArray(),
        ];
    }

    public function find(string $id, CategoryFindUseCase $useCase)
    {
        $response = $useCase->execute(new CategoryFindRequest($id));

        return [
            'result' => true,
            'data'   => $response->toArray(),
        ];
    }

    public function store(Request $request, CategoryStoreUseCase $useCase)
    {
        $request  = (new CategoryStoreRequest($request->input('name'), $request->input('slug')));
        $response = $useCase->execute($request);

        return [
            'result' => true,
            'data'   => $response->toArray(),
        ];
    }

    public function edit(Request $request, CategoryEditUseCase $useCase)
    {
        $request  = (new CategoryEditRequest($request->input('id'), $request->input('name'), $request->input('slug')));
        $response = $useCase->execute($request);

        return [
            'result' => true,
            'data'   => $response->toArray(),
        ];
    }

    public function delete(Request $request, CategoryDeleteUseCase $useCase)
    {
        $request  = (new CategoryDeleteRequest($request->input('id')));
        $response = $useCase->execute($request);

        return [
            'result' => true,
            'data'   => $response->toArray(),
        ];
    }
}
