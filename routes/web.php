<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

//Resource controllers - START
Route::resource('user','UserController');
Route::resource('permission','PermissionController');
Route::resource('role','RoleController');

//Resource controllers - END

Route::get('/profile','UserController@profile')->name('user.profile');

Route::get('/password','UserController@getPasswordPage')->name('user.getPasswordPage');

Route::post('/postProfile','UserController@postProfile')->name('user.postProfile');

Route::post('/postProfile','UserController@updatePassword')->name('user.updatePassword');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//axios routes
Route::get('/getAllPermissions','PermissionController@getAllPermission');
Route::post('/postRole','RoleController@store');

