<?php

namespace App\Repositories;

use App\Admin;
use App\Models\Article;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
	public function all($option)
	{
		$field = Article::select(['id', 'title', 'slug', 'content', 'banner', 'status', 'created_by', 'created_at', 'updated_at']);

		return $option == 'all' ? $field->orderBy('created_at', 'desc')->get() : $field;
	}

	public function create($request)
	{
		$inputs = $request->all();
		$inputs['created_by'] = auth()->user()->id;
		$inputs['banner'] = $this->processImage($request->file('banner'), 'create');

		Article::create($inputs);
	}

	public function findById($id)
	{
		return Article::findOrFail($id);
	}

	public function findBySlug($slug)
	{
		return Article::whereSlug($slug)->first();
	}

	public function update($request, $id)
	{
		$model = $this->findById($id);

		$inputs = $request->all();
		$inputs['slug'] = SlugService::createSlug(Article::class, 'slug', $request->title);
        $inputs['banner'] = $this->processImage($request->file('banner'), 'update', $model);

		$model->update($inputs);
	}

	public function delete($id)
	{
		$model = $this->findById($id);
		$model->delete();
	}

	public function draftOrPublish($id, $status)
	{
		$model = $this->findById($id);
		$model->update(['status' => $status]);
	}

	public function authorArray()
	{
		return Admin::pluck('name', 'id')->all();
	}

	private function processImage($banner, $action, $model = null)
	{
		$bannerName = $action == 'create' ? null : $model->banner;

		if (!empty($banner)) {
			if ($action == 'update') {
				\Storage::delete($model->banner);
			}

			$bannerName = $banner->store('public/article-banner');
		}

		return $bannerName;
	}
}