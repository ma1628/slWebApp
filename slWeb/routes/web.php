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

Route::get('/{order?}', 'HomeController')
    ->where('order', '(updated_at|rating)')
    ->name('home');
Route::get('/getTags', 'TagListController')
    ->name('tagList');
Route::get('sloganList', 'SloganListController')
    ->name('sloganList');
Route::get('sloganListByTagSearch/{tag_id}', 'SloganListByTagSearchController')
    ->where('tag_id', '[0-9]+')
    ->name('sloganListByTagSearch');
Route::get('/inputSlogan', 'InputSloganController')
    ->name('inputSlogan');
Route::post('/addSlogan', 'AddSloganController')
    ->name('addSlogan');
Route::get('sloganDetail/{slogan_id}', 'SloganDetailController')
    ->where('slogan_id', '[0-9]+')
    ->name('sloganDetail');
Route::get('sloganDetail/editSlogan/{slogan_id}', 'EditSloganController')
    ->where('slogan_id', '[0-9]+')
    ->name('editSlogan');
Route::post('sloganDetail/updateSlogan', 'UpdateSloganController')
    ->name('updateSlogan');
Route::post('sloganDetail/addComment', 'AddCommentController')
    ->name('addComment');
Route::post('sloganDetail/deleteComment', 'DeleteCommentController')
    ->name('deleteComment');
Route::get('sloganDetail/searchTag', 'SearchTagController')
    ->name('searchTag');
Route::get('/inputContact', 'InputContactController')
    ->name('inputContact');
Route::post('/sendContact', 'SendContactController')
    ->name('sendContact');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
