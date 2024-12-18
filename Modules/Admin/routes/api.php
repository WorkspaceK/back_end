<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\PersonController;
use Modules\Admin\App\Http\Controllers\PublicationController;
/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('admin', fn (Request $request) => $request->user())->name('admin');
});

Route::prefix('admins')->group(function () {
    Route::prefix('persons')->group(function () {
        Route::get('/', [PersonController::class, 'index']);

        Route::get('/page', [PersonController::class, 'get_by_page']);
        Route::get('/{id}/show', [PersonController::class, 'show']);
        Route::get('/search', [PersonController::class, 'search']);
        Route::get('/{identification}/has-by-identifi', [PersonController::class, 'hasByIdentifi']);
        Route::get('/{email}/has-by-email', [PersonController::class, 'hasByEmail']);
        Route::get('/get-list-sort-order', [PersonController::class, 'getListSortOrder']);
        Route::get('/show-person-list-by-code', [PersonController::class, 'showPersonListByCode']);
        Route::get('/{id}/student/show-student-list', [PersonController::class, 'showStudentList']);
        Route::get('/has-student-list', [PersonController::class, 'hasStudentList']);

        Route::post('/store', [PersonController::class, 'store']);
        Route::patch('/{id}/update', [PersonController::class, 'update']);
        Route::patch('/{id}/update-status', [PersonController::class, 'updateStatus']);
        Route::delete('/{id}/delete', [PersonController::class, 'destroy']);
        Route::post('/delete-multiple', [PersonController::class, 'deleteMultiple']);
        Route::post('/{id}/record', [PersonController::class, 'record']);
        Route::post('/record-multiple', [PersonController::class, 'recordMultiple']);
        Route::post('/import-excel-data', [PersonController::class, 'importExcelData']);

        Route::get('/export-csv', [PersonController::class, 'exportCsv']);
        Route::get('/export-xlsx', [PersonController::class, 'exportXlsx']);
    });

    Route::prefix('publications')->group(function () {
        Route::get('/', [PublicationController::class, 'index']);

        Route::get('/get-publication-list', [PersonController::class, 'getPersonList']);
        Route::get('/{id}/show', [PersonController::class, 'show']);
        Route::get('/search', [PersonController::class, 'search']);
        Route::get('/{identification}/has-by-identifi', [PersonController::class, 'hasByIdentifi']);
        Route::get('/{email}/has-by-email', [PersonController::class, 'hasByEmail']);
        Route::get('/get-list-sort-order', [PersonController::class, 'getListSortOrder']);
        Route::get('/show-publication-list-by-code', [PersonController::class, 'showPersonListByCode']);
//        Route::get('/{id}/student/show-student-list', [PersonController::class, 'showStudentList']);
        Route::get('/has-student-list', [PersonController::class, 'hasStudentList']);

        Route::post('/store', [PersonController::class, 'store']);
        Route::patch('/{id}/update', [PersonController::class, 'update']);
        Route::patch('/{id}/update-status', [PersonController::class, 'updateStatus']);
        Route::delete('/{id}/delete', [PersonController::class, 'destroy']);
        Route::post('/delete-multiple', [PersonController::class, 'deleteMultiple']);
        Route::post('/{id}/record', [PersonController::class, 'record']);
        Route::post('/record-multiple', [PersonController::class, 'recordMultiple']);
        Route::post('/import-excel-data', [PersonController::class, 'importExcelData']);

        Route::get('/export-csv', [PersonController::class, 'exportCsv']);
        Route::get('/export-xlsx', [PersonController::class, 'exportXlsx']);
    });
});
