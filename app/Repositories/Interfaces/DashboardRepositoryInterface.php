<?php

namespace App\Repositories\Interfaces;

interface DashboardRepositoryInterface
{
    /**
     * @return mixed
     */
    public function loadTotalData();

    /**
     * @return mixed
     */
    public function lineChartInit();

    /**
     * @param $request
     * @return mixed
     */
    public function lineChartSource($request);
}
