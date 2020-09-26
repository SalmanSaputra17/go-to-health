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
    /**
     * @var string
     */
    private $route;

    /**
     * @var \App\Models\Food
     */
    private $model;

    /**
     * @var \App\Repositories\Interfaces\FoodRepositoryInterface
     */
    private $repository;

    /**
     * FoodController constructor.
     *
     * @param \App\Models\Food                                     $model
     * @param \App\Repositories\Interfaces\FoodRepositoryInterface $repository
     */
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

    /**
     * @return mixed
     */
    public function getData()
    {
        $model = $this->repository->all();

        return Table::of($model)->addColumn('action', function ($model) {
                $edit = \Html::link(url($this->route . '/edit', ['id' => encryptStringValue($model->id)]), 'Edit',
                    ['class' => 'btn btn-info btn-sm']);

                $delete = \Html::link(url($this->route . '/delete', ['id' => encryptStringValue($model->id)]), 'Delete',
                    ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure ?")']);

                return $edit . " " . $delete;
            })->rawColumns(['action'])->make();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return $this->renderView('index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        return $this->renderView('form', [
            'action' => 'create',
            'model'  => $this->model,
        ]);
    }

    /**
     * @param \App\Http\Requests\FoodRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(FoodRequest $request)
    {
        $result = $this->repository->create($request);

        alert('Success', 'New food has been added.', 'success');

        return redirect(url($this->route));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        return $this->renderView('form', [
            'action' => 'update',
            'model'  => $this->repository->findById(decryptStringValue($id))
        ]);
    }

    /**
     * @param \App\Http\Requests\FoodRequest $request
     * @param                                $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdate(FoodRequest $request, $id)
    {
        $result = $this->repository->update($request, decryptStringValue($id));

        alert('Success', 'Food has been updated.', 'success');

        return redirect(url($this->route));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getDelete($id)
    {
        $result = $this->repository->delete(decryptStringValue($id));

        alert('Success', 'Food has been deleted.', 'success');

        return redirect(url($this->route));
    }
}
