<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleController extends Controller
{
    /**
     * @var \App\Models\Article
     */
    private $model;

    /**
     * @var \App\Repositories\Interfaces\ArticleRepositoryInterface
     */
    private $repository;

    /**
     * ArticleController constructor.
     *
     * @param \App\Models\Article                                     $model
     * @param \App\Repositories\Interfaces\ArticleRepositoryInterface $repository
     */
    public function __construct(Article $model, ArticleRepositoryInterface $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $result = $this->repository->all('field',
                ['id', 'title', 'slug', 'status', 'created_at'])->whereStatus('publish')->get();

            return response()->json([
                'status' => 'SUCCESS',
                'data'   => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        try {
            $result = $this->repository->findBySlug($slug);

            return response()->json([
                'status' => 'SUCCESS',
                'data'   => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
