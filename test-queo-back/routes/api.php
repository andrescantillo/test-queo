<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EmployeesController;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('companies', CompaniesController::class);
    Route::resource('employees', EmployeesController::class);
});

Route::post('/auth/login', [AuthenticationController::class,'login'])->name('auth.login');
Route::post('/auth/register', [AuthenticationController::class,'register'])->name('registerUser');
