<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', 'App\Http\Controllers\Authentication@Login');

Route::group(['prefix' => '/', 'middleware' => ['jwt-auth']], function(){
    Route::post('/create-account', 'App\Http\Controllers\AccountsController@createAccount');
    Route::post('/delete-account', 'App\Http\Controllers\AccountsController@deleteAccount');

    Route::get('/view-companies', 'App\Http\Controllers\CompanyController@viewCompanies');
    Route::get('/view-employees', 'App\Http\Controllers\EmployeeController@viewEmployees');


});
