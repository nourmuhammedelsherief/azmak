<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function chartIndex(Request $request)
    {

        if (in_array($request->type, ['category_more', 'category_less' , 'product_more' , 'product_less'])) :
            $requestChartData =  $this->requestCategoryAndProductChart($request);
        else :
            $requestChartData =  $this->homeRequestChart($request);
        endif;

        return view('restaurant.chart_report', compact('requestChartData'));
    }



    private function requestCategoryAndProductChart(Request $request)
    {
        $restaurantId = 0;
        if (auth('restaurant')->check() and $user = auth('restaurant')->user()) :
            if ($user->type == 'employee') :
                $restaurantId = $user->restaurant_id;
            else :
                $restaurantId = $user->id;
            endif;
        endif;
        $type =  (!empty($request->type) and in_array($request->type, ['category_more', 'category_less', 'product_more', 'product_less'])) ? $request->type : 'product_more';
        $period = (!empty($request->period) and in_array($request->period, ['60_min', 'week', '24h', '30_day', 'year'])) ? $request->period : '60_min';
        $condition = [];
        $per = 5;
        $sort = 'desc';
        $groupby = 'category_id';
        if ($type == 'category_more') :
            $sort = 'desc';
            $mSql = "FROM
            logs as l join menu_categories as m on(l.category_id = m.id)
        WHERE
            m.restaurant_id = {$restaurantId} and m.active = 'true'";
        elseif ($type == 'category_less') :
            $sort = 'asc';
            $mSql = "FROM
            logs as l join menu_categories as m on(l.category_id = m.id)
        WHERE
            m.restaurant_id = {$restaurantId} and m.active = 'true'";

        elseif ($type == 'product_less') :
            $sort = 'asc';
            $groupby = 'product_id';
            $mSql = "FROM
                logs as l join products as m on(l.product_id = m.id)
            WHERE
                m.restaurant_id = {$restaurantId} and m.active = 'true'";
        else :
            $groupby = 'product_id';
            $sort = 'desc';
            $mSql = "FROM
                        logs as l join products as m on(l.product_id = m.id)
                    WHERE
                        m.restaurant_id = {$restaurantId} and m.active = 'true'";
        endif;
        if ($period == '60_min') :
            $condition[] = 'l.created_at >= "' . Carbon::now()->subMinutes(60)->format('Y-m-d H:i:s') . '"';
            $per = 1;
        elseif ($period == '24h') :
            $condition[] = 'l.created_at >= "' . Carbon::now()->subHours(24)->format('Y-m-d H:i:s') . '"';
            $per = 5;
        elseif ($period == 'week') :
            $condition[] = 'l.created_at >= "' . Carbon::now()->subDays(7)->format('Y-m-d H:i:s') . '"';
            $per = 60;
        elseif ($period == '30_day') :
            $condition[] = 'l.created_at >= "' . Carbon::now()->subDays(30)->format('Y-m-d H:i:s') . '"';
            $per = 60;
        elseif ($period == 'year') :
            $condition[] = 'l.created_at >= "' . date('Y') . '-01-01"';
            $per = 60 * 24;
        endif;
        $condition = count($condition) > 0 ?  ' and ' . implode(' and ', $condition) : '';
        $sql = "SELECT
            {$groupby} , m.name_ar , m.name_en ,
            COUNT(*) AS row_count
                {$mSql}  {$condition}
                GROUP BY
                    {$groupby}
                ORDER BY
                row_count {$sort};
        ";
        $sql;
        $query = DB::select($sql);
        return $query;
    }

    private function homeRequestChart(Request $request)
    {
        $restaurantId = 0;
        if (auth('restaurant')->check() and $user = auth('restaurant')->user()) :
            if ($user->type == 'employee') :
                $restaurantId = $user->restaurant_id;
            else :
                $restaurantId = $user->id;
            endif;
        endif;
        $type =  'easymenu';
        $period = (!empty($request->period) and in_array($request->period, ['60_min', 'week', '24h', '30_day', 'year'])) ? $request->period : '60_min';
        $condition = [];
        $per = 5;
        if ($type == 'easymenu') :
            $condition[] = '(url like "%/restaurants/%" or url like "%/menu_product/%") and easymenu_restaurant_id = ' . $restaurantId;
        endif;
        if ($period == '60_min') :
            $condition[] = 'created_at >= "' . Carbon::now()->subMinutes(60)->format('Y-m-d H:i:s') . '"';
            $per = 1;
        elseif ($period == '24h') :
            $condition[] = 'created_at >= "' . Carbon::now()->subHours(24)->format('Y-m-d H:i:s') . '"';
            $per = 5;
        elseif ($period == 'week') :
            $condition[] = 'created_at >= "' . Carbon::now()->subDays(7)->format('Y-m-d H:i:s') . '"';
            $per = 60;
        elseif ($period == '30_day') :
            $condition[] = 'created_at >= "' . Carbon::now()->subDays(30)->format('Y-m-d H:i:s') . '"';
            $per = 60;
        elseif ($period == 'year') :
            $condition[] = 'created_at >= "' . date('Y') . '-01-01"';
            $per = 60 * 24;
        endif;
        $condition = count($condition) > 0 ?  ' and ' . implode(' and ', $condition) : '';
        $sql = "SELECT
            FLOOR(UNIX_TIMESTAMP(created_at) / ({$per} * 60)) AS interval_start,
            DATE_FORMAT(FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) / ({$per} * 60)) * ({$per} * 60)), '%Y-%m-%d %h:%i %p') AS interval_start_datetime,
            COUNT(*) AS row_count
                FROM
                    logs
                WHERE
                    id != 0 {$condition}
                GROUP BY
                    interval_start
                ORDER BY
                    interval_start desc;
        ";
        // return $sql;
        $query = DB::select($sql);
        return $query;
    }
}
