<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::group([
    'prefix' => 'app',
    'middleware' => ['auth', 'localization'],
], function () {
    //general routes
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('user', UserController::class)->except(['show']);
    Route::resource('access', AccessController::class)->except(['show'])->middleware('admin');

    // absence tool routes
    Route::group(['middleware' => ['absence']
    ], function () {
        Route::resource('period', PeriodController::class)->except(['show', 'edit', 'update', 'create']);
        Route::get('period/indexall', 'PeriodController@indexAll')->name('period.indexall');

        //Routes / Controllers for admins
        Route::group([
            'middleware' => ['auth', 'admin']
        ], function () {
            Route::resource('reason', ReasonController::class)->except(['show']);
            Route::get('confirm/', 'ConfirmController@index')->name('confirm.index');
            Route::post('confirm/', 'ConfirmController@confirm')->name('confirm.confirm');


            Route::get('report', 'ReportingController@index')->name('report');
        });
    });
});







