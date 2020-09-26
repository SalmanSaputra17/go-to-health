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
    /**
     * @return array|mixed
     */
    public function loadTotalData()
    {
        $foods = Cache::rememberForever('__foods', function () {
            return Food::all()->count();
        });

        $articles = Cache::rememberForever('__articles', function () {
            return Article::all()->count();
        });

        $users = Cache::rememberForever('__users', function () {
            return User::all()->count();
        });

        return [
            'foods'    => $foods,
            'articles' => $articles,
            'users'    => $users
        ];
    }

    /**
     * @return \App\Charts\UserActivityLogChart|mixed
     */
    public function lineChartInit()
    {
        $source = url('/home/line-chart-source');

        $chart = new Chart;
        $chart->labels([
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ])->load($source);

        return $chart;
    }

    /**
     * @param $request
     * @return mixed|string
     */
    public function lineChartSource($request)
    {
        $activities = Cache::rememberForever('__activities', function () {
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            $query = UserActivityLog::select(\DB::raw('MONTH(created_at) as month, COUNT(*) as total'))->whereRaw('YEAR(created_at) = YEAR(NOW())')->groupBy("month")->pluck('total',
                    'month')->toArray();

            for ($i = 0; $i < count($months); $i++) {
                if ( ! isset($query[$months[$i]])) {
                    $query[$months[$i]] = 0;
                }
            }

            ksort($query);
            $result = [];

            foreach ($query as $key => $value) {
                $result[] = $value;
            }

            return $result;
        });

        $chart = new Chart;
        $chart->dataset('User Activity Chart', 'line', $activities)->options([
            'fill'            => true,
            'color'           => '#4e73df',
            'backgroundColor' => 'rgb(106, 90, 205, 0.7)'
        ]);

        return $chart->api();
    }
}
