<?php

namespace App\Providers;

use App\Models\SalemanList;
use App\Models\ScheduleList;
use App\Models\SunabList;
use App\Models\AccountList;
use App\Models\StockList;
use App\Observers\SalemanListObserver;
use App\Observers\ScheduleListObserver;
use App\Observers\SunabListObserver;
use App\Observers\AccountListObserver;
use App\Observers\StockListObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //쿼리로그
        //if (env('APP_DEBUG')) {
        DB::listen(function ($query) {
            $searchName = "`sessions`";

            if (strpos($query->sql, $searchName) === false) {

                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
                );
            }
        });
        //}
    }
}
