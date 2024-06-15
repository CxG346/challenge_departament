<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\EmployeeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Departament
Route::get('/departament', [DepartamentController::class, 'getData']);
Route::get('/departament-format/{perPage?}/{sortField?}/{sortOrder?}', [DepartamentController::class, 'formatData']);
Route::get('/departament-search/{filter}/{search}', [DepartamentController::class, 'searchData']);
Route::post('/departament', [DepartamentController::class, 'store']);
Route::get('/departament/listNames', [DepartamentController::class, 'listNameDepartaments']);
Route::get('/departament/{id}', [DepartamentController::class, 'show']);
Route::put('/departament/{id}', [DepartamentController::class, 'update']);
Route::delete('/departament/{id}', [DepartamentController::class, 'destroy']);
Route::post('/departament/{id}/ambassador', [DepartamentController::class, 'applyAmbassador']);
Route::post('/departament/{id}/dad', [DepartamentController::class, 'applyDaddy']);
Route::get('/departament/{id}/subdepartaments', [DepartamentController::class, 'showSubdepartaments']);

//Employee
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/employee/{id}', [EmployeeController::class, 'show']);