<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function() {
    Route::namespace('API')->name('api.')->group(function(){
        Route::prefix('/poll')->group(function(){
            Route::get('/{id}/stats', 'PollController@stats')->name('poll_status');
            Route::post('/{id}/vote', 'PollController@vote')->name('add_vote');
            Route::get('/{id}', 'PollController@show')->name('single_poll');  
            Route::post('/', 'PollController@store')->name('store_poll'); 
        });
    });
});