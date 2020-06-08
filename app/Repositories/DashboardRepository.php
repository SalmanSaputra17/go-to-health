<?php

namespace App\Repositories;

use App\Models\Food;
use App\Models\Article;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\DashboardRepositoryInterface;
use App\Charts\UserActivityLogChart as Chart;

class DashboardRepository implements DashboardRepositoryInterface
{
	public function loadTotalData()
	{
		$foods = Cache::rememberForever('__foods', function() {
            return Food::all()->count();
        });

		$articles = Cache::rememberForever('__articles', function() {
            return Article::all()->count();
        });

        $users = Cache::rememberForever('__users', function() {
            return User::all()->count();
        });

		return [
			'foods' => $foods,
			'articles' => $articles,
			'users' => $users
		];
	}

	public function lineChartInit()
	{
		$source = url('/home/line-chart-source');

		$chart = new Chart;
		$chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($source);
	
		return $chart;
	}

	public function lineChartSource($request)
	{
		$activity = Cache::rememberForever('__activities', function() {
			return UserActivityLog::select(\DB::raw('COUNT(*) as count'))
				->groupBy(\DB::raw("Month(created_at)"))
				->pluck('count');
		});

		$chart = new Chart;
		$chart->dataset('User Activity Chart', 'line', $activity)->options([
			'fill' => true,
			'color' => '#4e73df',
			'backgroundColor' => 'rgb(106, 90, 205, 0.5)'
		]);
	
		return $chart->api();
	}
}