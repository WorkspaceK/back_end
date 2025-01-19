<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\DegreeController;
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
    Route::prefix('degrees')->group(function () {
        Route::get('/get-all', [DegreeController::class, 'getAll']);
        Route::get('/', [DegreeController::class, 'getByPage']);
        Route::post('/', [DegreeController::class, 'store']);
        Route::get('/{id}', [DegreeController::class, 'getById'])->where('id', '[0-9]+');
        Route::patch('/{id}', [DegreeController::class, 'update']);

        Route::delete('/{id}', [DegreeController::class, 'destroy']);
        Route::post('/delete', [DegreeController::class, 'massDelete']);

        Route::post('/{id}/copy', [DegreeController::class, 'copy']);
        Route::post('/copy', [DegreeController::class, 'massCopy']);

        Route::post('/import', [DegreeController::class, 'import']);

        Route::get('{id}/export', [DegreeController::class, 'exportById']);
        Route::post('/export', [DegreeController::class, 'massExport']);

        Route::get('/get-by-id', [DegreeController::class, 'getByIds']);
        Route::get('/get-by-code', [DegreeController::class, 'getByCodes']);
        Route::patch('/{id}/update-status', [DegreeController::class, 'updateStatus']);

        Route::get('/{code}/has-by-code', [DegreeController::class, 'hasByCode']);
        Route::get('/{name}/has-by-name', [DegreeController::class, 'hasByName']);

        Route::get('/recycle', [DegreeController::class, 'recycle']);
        Route::get('{id}/show-recycled', [DegreeController::class, 'showRecycled']);
        Route::post('/{id}/restore', [DegreeController::class, 'restore']);
        Route::post('/restore-multiple', [DegreeController::class, 'restoreMultiple']);
        Route::post('/restore-all', [DegreeController::class, 'restoreAll']);
        Route::delete('{id}/force-delete', [DegreeController::class, 'forceDelete']);
        Route::delete('force-delete-multiple', [DegreeController::class, 'forceDeleteMultiple']);
        Route::delete('force-delete-all', [DegreeController::class, 'forceDeleteAll']);
    });

    Route::prefix('persons')->group(function () {
        Route::get('/', [PersonController::class, 'index']);
        Route::get('/', [PersonController::class, 'get_by_page']);
        Route::post('/', [PersonController::class, 'store']);
        Route::get('/{id}', [PersonController::class, 'get_by_id']);
        Route::patch('/{id}', [PersonController::class, 'update']);

        Route::delete('/{id}', [PersonController::class, 'destroy']);
        Route::post('/delete', [PersonController::class, 'mass_delete']);

        Route::post('/{id}/copy', [PersonController::class, 'copy']);
        Route::post('/copy', [PersonController::class, 'mass_copy']);

        Route::post('/import', [PersonController::class, 'import_data']);

        Route::get('{id}/export', [PersonController::class, 'export_by_id']);
        Route::post('/export', [PersonController::class, 'mass_export']);

        Route::get('/get_by_ids', [PersonController::class, 'get_by_ids']);

        Route::get('/{identification}/has-by-identifi', [PersonController::class, 'hasByIdentifi']);
        Route::get('/{email}/has-by-email', [PersonController::class, 'hasByEmail']);
        Route::get('/get-list-sort-order', [PersonController::class, 'getListSortOrder']);
        Route::get('/show-person-list-by-code', [PersonController::class, 'showPersonListByCode']);
        Route::get('/{id}/student/show-student-list', [PersonController::class, 'showStudentList']);
        Route::get('/has-student-list', [PersonController::class, 'hasStudentList']);
        Route::patch('/{id}/update-status', [PersonController::class, 'updateStatus']);
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
