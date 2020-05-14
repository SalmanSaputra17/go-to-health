<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

class HomeController extends BaseController
{
	private $repository;

    public function __construct(DashboardRepositoryInterface $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;

        view()->share('__title_page', 'General Dashboard');
    }

    public function index()
    {
        return $this->renderView('home', [
        	'totalData' => $this->repository->loadTotalData(),
        	'lineChart' => $this->repository->lineChartInit(),
        ]);
    }

    public function lineChartSource(Request $request)
    {
    	return $this->repository->lineChartSource($request);
    }
}