<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
	public function all($option);

	public function create($request);

	public function findById($id);

	public function update($request, $id);

	public function delete($id);
}