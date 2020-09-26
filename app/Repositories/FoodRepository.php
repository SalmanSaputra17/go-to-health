<?php

namespace App\Repositories;

use App\Models\Food;
use App\Repositories\Interfaces\FoodRepositoryInterface;

class FoodRepository implements FoodRepositoryInterface
{
    /**
     * @param string $option
     * @return mixed
     */
    public function all($option = 'get')
    {
        $field = Food::select(['id', 'name', 'calory', 'portion']);

        return $option == 'get' ? $field->orderBy('name', 'asc')->get() : $field;
    }

    /**
     * @param $request
     * @return mixed|void
     */
    public function create($request)
    {
        $inputs = $request->all();
        $inputs['created_by'] = auth()->user()->id;

        Food::create($inputs);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return Food::findOrFail($id);
    }

    /**
     * @param $request
     * @param $id
     * @return mixed|void
     */
    public function update($request, $id)
    {
        $model = $this->findById($id);
        $model->update($request->all());
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $model = $this->findById($id);
        $model->delete();
    }
}
