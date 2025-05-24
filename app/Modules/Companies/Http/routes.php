<?php

declare(strict_types=1);

use App\Modules\Companies\Http\Controllers\CompanyController;
use App\Modules\Companies\Http\Controllers\CompanyEmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('/companies')
    ->name('companies.')
    ->controller(CompanyController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{company}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::patch('/{company}', 'update')->name('update');
        Route::delete('/{company}', 'destroy')->name('destroy');

        Route::prefix('/{company}/employees')
            ->name('employees.')
            ->controller(CompanyEmployeeController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{employee}', 'show')->name('show');
                Route::post('/', 'store')->name('store');
                Route::patch('/{employee}', 'update')->name('update');
                Route::delete('/{employee}', 'destroy')->name('destroy');
            });
    });
