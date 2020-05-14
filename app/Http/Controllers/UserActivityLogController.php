<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\UserActivityLogRepositoryInterface;
use Table;

class UserActivityLogController extends BaseController
{
    private $route;
    private $model;
    private $repository;

    public function __construct(UserActivityLog $model, UserActivityLogRepositoryInterface $repository)
    {
    	parent::__construct();

    	$this->view .= 'user-activity-log.';
    	$this->route = '/user-activity-log';
        $this->model = $model;
        $this->repository = $repository;

        view()->share('__title_page', 'User Activity Log');
        view()->share('__route', $this->route);
    }

    public function getIndex()
    {
        return $this->renderView('index');
    }

    public function getUserList()
    {
        $model = $this->repository->userList('all');

        return Table::of($model)
            ->addColumn('action', function($model) {
                $view = \Html::link(url($this->route . '/detail', ['id' => encryptStringValue($model->id)]), 'View activity log', ['class' => 'btn btn-primary btn-sm']);

                return $view;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function getDetail($id)
    {
        return $this->renderView('detail', [
            'user' => $this->repository->findUserById(decryptStringValue($id))
        ]);
    }

    public function getUserLog(Request $request, $userId)
    {
        $model = $this->repository->userLog(decryptStringValue($userId));

        if (!empty($request->filter_start_date) && empty($request->filter_end_date)) {
            $model = $model->whereDate('created_at', '>=', $request->filter_start_date);
        }

        if (empty($request->filter_start_date) && !empty($request->filter_end_date)) {
            $model = $model->whereDate('created_at', '<=', $request->filter_end_date);
        }

        if (!empty($request->filter_start_date) && !empty($request->filter_end_date)) {
            $model = $model->whereDate('created_at', '>=', $request->filter_start_date)
                ->whereDate('created_at', '<=', $request->filter_end_date);
        }

        return Table::of($model)
            ->addColumn('time', function($model) {
                return reformatDateToReadable($model->created_at);
            })
            ->rawColumns(['time'])
            ->make();
    }
}