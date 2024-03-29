<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api/v1','namespace' => '\App\Http\Controllers'], function($router)
{
	$router->post('car','CarController@createCar');

	$router->put('car/{id}','CarController@updateCar');
 	 
	$router->delete('car/{id}','CarController@deleteCar');
        
	$router->get('car','CarController@index');
});



