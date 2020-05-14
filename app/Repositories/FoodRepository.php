<?php

namespace App\Repositories;

use App\Models\Food;
use App\Repositories\Interfaces\FoodRepositoryInterface;

class FoodRepository implements FoodRepositoryInterface
{
	public function all($option)
	{
		$field = Food::select(['id', 'name', 'calory', 'portion']);

		return $option == 'all' ? $field->orderBy('name', 'asc')->get() : $field;
	}

	public function create($request)
	{
		$inputs = $request->all();
		$inputs['created_by'] = auth()->user()->id;

		Food::create($inputs);
	}

	public function findById($id)
	{
		return Food::findOrFail($id);
	}

	public function update($request, $id)
	{
		$model = $this->findById($id);
		$model->update($request->all());
	}

	public function delete($id)
	{
		$model = $this->findById($id);
		$model->delete();
	}
}