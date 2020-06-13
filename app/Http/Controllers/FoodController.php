<?php

namespace App\Http\Controllers;

use App\Models\Food;
// use Illuminate\Http\Request;
use App\Http\Requests\FoodRequest;
use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\FoodRepositoryInterface;
use Table;

class FoodController extends BaseController
{
	private $route;
	private $model;
	private $repository;

    public function __construct(Food $model, FoodRepositoryInterface $repository)
    {
    	parent::__construct();

    	$this->view .= 'food.';
    	$this->route = '/food';
    	$this->model = $model;
    	$this->repository = $repository;

    	view()->share('__title_page', 'Foods Management');
    	view()->share('__route', $this->route);
    }

    public function getData()
    {
    	$model = $this->repository->all();

    	return Table::of($model)
    		->addColumn('action', function($model) {
    			$edit = \Html::link(url($this->route . '/edit', ['id' => encryptStringValue($model->id)]), 'Edit', ['class' => 'btn btn-info btn-sm']);

    			$delete = \Html::link(url($this->route . '/delete', ['id' => encryptStringValue($model->id)]), 'Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure ?")']);

    			return $edit . " " . $delete;
    		})
    		->rawColumns(['action'])
    		->make();
    }

    public function getIndex()
    {
    	return $this->renderView('index');
    }

    public function getCreate()
    {
    	return $this->renderView('form', [
    		'action' => 'create',
    		'model' => $this->model,
    	]);
    }

    public function postCreate(FoodRequest $request)
    {
    	$result = $this->repository->create($request);

    	alert('Success', 'New food has been added.', 'success');
    	
    	return redirect(url($this->route));
    }

    public function getEdit($id)
    {
    	return $this->renderView('form', [
    		'action' => 'update',
    		'model' => $this->repository->findById(decryptStringValue($id))
    	]);
    }

    public function postUpdate(FoodRequest $request, $id)
    {
    	$result = $this->repository->update($request, decryptStringValue($id));

    	alert('Success', 'Food has been updated.', 'success');
    	
    	return redirect(url($this->route));
    }

    public function getDelete($id)
    {
    	$result = $this->repository->delete(decryptStringValue($id));

    	alert('Success', 'Food has been deleted.', 'success');
    	
    	return redirect(url($this->route));
    }
}
