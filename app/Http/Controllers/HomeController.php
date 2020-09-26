<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

class HomeController extends BaseController
{
    /**
     * @var \App\Repositories\Interfaces\DashboardRepositoryInterface
     */
    private $repository;

    /**
     * HomeController constructor.
     *
     * @param \App\Repositories\Interfaces\DashboardRepositoryInterface $repository
     */
    public function __construct(DashboardRepositoryInterface $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;

        view()->share('__title_page', 'General Dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->renderView('home', [
            'totalData' => $this->repository->loadTotalData(),
            'lineChart' => $this->repository->lineChartInit(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function lineChartSource(Request $request)
    {
        return $this->repository->lineChartSource($request);
    }
}
