<?php

namespace App\Repositories\Interfaces;

interface DashboardRepositoryInterface
{
	public function loadTotalData();

	public function lineChartInit();

	public function lineChartSource($request);
}