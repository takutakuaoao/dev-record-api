<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreRequest;
use App\Http\Response\SuccessResponse;
use Carbon\Carbon;
use DevRecord\Infrastructure\Repository\Article\ArticleColumns;
use DevRecord\Infrastructure\Repository\Article\ArticleDbRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleDbRepository $repository,
    ) {
    }

    public function index(Request $request)
    {
        $result = $this->repository->all();

        return (new SuccessResponse([
            'allCount' => count($result),
            'list'     => $result,
        ]))->toArray();
    }

    public function show(string $id)
    {
        $article = $this->repository->find($id);

        return (new SuccessResponse([
            'item' => $article,
        ]))->toArray();
    }

    public function store(StoreRequest $request)
    {
        $articleColumns = new ArticleColumns(
            $registeredId = uniqid(),
            (int)$request->type(),
            $request->categoryId(),
            $request->title(),
            $request->content(),
            $request->slug(),
            $request->mainImgUrl(),
            Carbon::now(),
            null,
        );
        $this->repository->store($articleColumns);

        return (new SuccessResponse(['id' => $registeredId]))->toArray();
    }

    public function update(Request $request)
    {
        $articleColumns = new ArticleColumns(
            $request->input('id'),
            $request->input('type'),
            $request->input('categoryId'),
            $request->input('title'),
            $request->input('content'),
            $request->input('slug'),
            $request->input('mainImgUrl'),
            null,
            Carbon::now(),
        );
        $this->repository->update($articleColumns);

        return (new SuccessResponse(['id' => $request->input('id')]))->toArray();
    }

    public function publicIndex()
    {
        $result = $this->repository->fetchAllPublicType();

        return (new SuccessResponse([
            'list'     => $result,
            'allCount' => count($result),
        ]))->toArray();
    }

    public function publicShow(string $categorySlug, string $articleSlug)
    {
        $result = $this->repository->findCategorySlugAndArticleSlug($categorySlug, $articleSlug);

        return (new SuccessResponse([
            'item' => $result,
        ]))->toArray();
    }
}
