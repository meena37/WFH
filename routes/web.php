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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');
	Route::resource('worklist','WorklistController');
    Route::resource('supervisor','SupervisorController');
	Route::resource('tasktype','TasktypeController');
	Route::resource('tasks','TasksController');
	Route::resource('shift','ShiftController');
	Route::resource('tasklist','ItemController');
});
 Route::patch('/job_queue/updatejob/{id}', 'JobinqueueController@updatejob')->name('job_queue.updatejob');
 //queue
 Route::get('post','PostController@index');
Route::post('post-sortable','PostController@update');
 //Route::get('dragAndDroppable', array('as'=> 'dragAndDroppable', 'uses' => 'ItemController@itemView'));

// Route::get('tasklist', array('as'=> 'tasklist', 'uses' => 'ItemController@index'));
Route::post('update-items', array('as'=> 'update.items', 'uses' => 'ItemController@updateItems'));