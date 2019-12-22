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

//Route::get('/', 'SloganController@getSlogans');
Route::get('/{order?}', 'SloganController@getOrderSlogans')
    ->where('order', '(updated_at|rating)')
    ->name('home');
Route::get('/getTags', 'SloganController@getTags')
    ->name('tagList');
Route::get('sloganList/{keyword}/{searchMethod}', 'SloganController@searchSlogans')
    ->where([
        'keyword' => '[^\s　]+',
        'searchMethod' => '(phrase|writer|source)'])
    ->name('sloganList');
Route::get('sloganList/{tag_id}', 'SloganController@sloganListByTagSearch')
    ->where('tag_id', '[0-9]+')
    ->name('sloganListByTagSearch');
Route::get('/inputSlogan', 'SloganController@inputSlogan')
    ->name('inputSlogan');
Route::post('/addSlogan', 'SloganController@addSlogan')
    ->name('addSlogan');
Route::get('sloganDetail/{slogan_id}', 'SloganController@getSloganDetail')
    ->where('slogan_id', '[0-9]+')
    ->name('sloganDetail');
Route::get('sloganDetail/editSlogan/{slogan_id}', 'SloganController@editSlogan')
    ->where('slogan_id', '[0-9]+')
    ->name('editSlogan');
Route::post('sloganDetail/updateSlogan', 'SloganController@updateSloganDetail')
    ->name('updateSlogan');
Route::post('sloganDetail/addComment', 'SloganController@addComment')
    ->name('addComment');
Route::post('sloganDetail/addTag', 'SloganController@addTag')
    ->name('addTag');
Route::get('sloganDetail/searchTag', 'SloganController@searchTag')
    ->name('searchTag');