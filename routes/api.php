<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuthenticated;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/admin', 'AdminController@store');
// Private  Routes
Route::middleware('checkauth')->group(function () {

    // Admin CR
    Route::get('/admin', 'AdminController@index');


    Route::middleware(['ensureadmin'])->group(function () {
        // Get admin user
        Route::get('/admin/me', 'AdminController@self');
        Route::get('/admin/mydocs', 'AdminController@docs');

        Route::get('/admin/signout', 'AdminController@signout');

        // GET ONE ADMIN
        Route::get('/admin/{id}', 'AdminController@show');


        // Submit new Doctor

        Route::post('/medic/doc', 'MedicController@requestNewMedic');

        // Get current doctor
    });

    Route::middleware(['ensuredoctor'])->group(function () {
        Route::get('/doctor/me', 'MedicController@self');
        Route::post('/doctor/off', 'MedicController@days_off');
        Route::post('/doctor/fix_time', 'MedicController@fix_time');
        Route::post('/doctor/about', 'MedicController@about');
    });
});

Route::middleware(['ensurevalide'])->group(function () {
    Route::post('/medic/continue', 'MedicController@continueSignUp');
});


/**
 * PUBLIC ROUTES
 */

// login routes
Route::post('/admin/login', 'AdminController@SignAdmin');
Route::post('/medic/login', 'MedicController@SignMedic');

Route::get('/medic/verify/{id}', 'MedicController@validateRequestEmail');
Route::get('/doctor/{id}', 'MedicController@show');

// Search

Route::get('/search/{spec}/{cat}/{name}', 'CommitSearch@index');
