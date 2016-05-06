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

Route::group(['prefix'=>'api'],function(){

    //ADVERTS ROUTES

    Route::get('/advert','AdvertsController@all');
    Route::get('/advert/my','AdvertsController@allMy');
    Route::get('/advert/{id}','AdvertsController@get');
    Route::get('/advert/{id}/offers','AdvertsController@getOffersByAdvert');
    Route::put('/advert','AdvertsController@create');
    Route::post('/advert/{id}','AdvertsController@update');
    Route::delete('/advert/{id}','AdvertsController@remove');

    // OFFERS ROUTES

    Route::get('/offer/','OfferController@all');
    Route::get('/offer/{id}','OfferController@get');
    Route::put('/offer/{id}','OfferController@create');
    Route::post('/offer/{id}','OfferController@update');
    Route::post('/offer/{id}/status','OfferController@statusChange');
    Route::delete('/offer/{id}','OfferController@remove');

});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');
Route::auth();
