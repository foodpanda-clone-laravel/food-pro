<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
], function () {
    Route::get('/hello', function(){
        return 'hello';
    });
});


/***
 * an example code to follow
 *  https://laraveldaily.com/post/laravel-routes-split-into-separate-files
 */
