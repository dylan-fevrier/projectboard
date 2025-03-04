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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/projects');
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/tasks', 'ProjectTaskController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTaskController@update');

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
