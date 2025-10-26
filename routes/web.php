<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;


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

Route::get('/home', function () {
    return redirect()->route('tasks.index');
})->name('home');

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('tasks', 'TaskController');
    Route::resource('activity', 'ActivityLogController');
    Route::get('activity-deleted', 'ActivityLogController@deleted')->name('activity.deleted');
    Route::post('activity/{id}/restore', 'ActivityLogController@restore')->name('activity.restore');
});

