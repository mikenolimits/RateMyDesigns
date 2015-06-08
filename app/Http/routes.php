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
get('/','DesignsController@index');
get('/designs/edit','DesignsController@edit');
get('/designs/results',[
	'as' => 'design.results',
	'uses' =>'DesignsController@getResults'
]);

resource('designs','DesignsController');
resource('ratings','RatingController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
