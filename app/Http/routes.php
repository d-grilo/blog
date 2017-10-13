<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {

    return view('welcome');
});

# Default make:auth
Route::auth();
Route::get('/home', 'HomeController@index');




Route::group(['middleware'=>'admin'], function () {

    Route::get('admin', function() {

        return view('admin.index');
    });

    Route::resource('admin/users', 'AdminUsersController');

    Route::resource('admin/posts', 'AdminPostsController');

});



# Test route
Route::get('/test', function () {

    $role = \App\Role::findOrFail(1);

    foreach($role->users as $user) {
        echo $user->name;
    }

});



