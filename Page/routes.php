<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Page Module Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('App\Modules\Page\Controllers')->group(function () {

	Route::group(['middleware' => ['auth', 'admin']], function () {
		Route::get('page/trashed', 'PageController@trashedList');
		Route::post('page/{id}/restore', 'PageController@restoreTrashedPage');
        Route::resource('page', 'PageController');
        Route::get('previewPage', 'PageController@previewPage');

	});

});