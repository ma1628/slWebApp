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

// home画面を表示
Route::get('/{order?}', 'HomeController')
    ->where('order', '(updated_at|rating)')
    ->name('home');

// タグ一覧画面を表示
Route::get('/getTags', 'TagListController')
    ->name('tagList');

// キャッチコピーの検索結果一覧画面を表示
Route::get('sloganList', 'SloganListController')
    ->name('sloganList');

// キャッチコピーの検索結果一覧画面（タグ検索）を表示
Route::get('sloganListByTagSearch/{tag_id}', 'SloganListByTagSearchController')
    ->where('tag_id', '[0-9]+')
    ->name('sloganListByTagSearch');

// キャッチコピー追加画面を表示
Route::get('/inputSlogan', 'InputSloganController')
    ->name('inputSlogan');

// キャッチコピーを追加してhomeにリダイレクト
Route::post('/addSlogan', 'AddSloganController')
    ->name('addSlogan');

// キャッチコピー詳細画面を表示
Route::get('sloganDetail/{slogan_id}', 'SloganDetailController')
    ->where('slogan_id', '[0-9]+')
    ->name('sloganDetail');

// キャッチコピー編集画面を表示
Route::get('sloganDetail/editSlogan/{slogan_id}', 'EditSloganController')
    ->where('slogan_id', '[0-9]+')
    ->name('editSlogan');

// キャッチコピーを更新してsloganDetailにリダイレクト
Route::post('sloganDetail/updateSlogan', 'UpdateSloganController')
    ->name('updateSlogan');

// コメントを追加してsloganDetailにリダイレクト
Route::post('sloganDetail/addComment', 'AddCommentController')
    ->name('addComment');

// コメントを削除してsloganDetailにリダイレクト
Route::post('sloganDetail/deleteComment', 'DeleteCommentController')
    ->name('deleteComment');

// タグの検索結果を返す（オートコンプリート用）
Route::get('sloganDetail/searchTag', 'SearchTagController')
    ->name('searchTag');

//　お問い合わせ画面を表示する
Route::get('/inputContact', 'InputContactController')
    ->name('inputContact');

// お問い合わせ内容を送信して、homeにリダイレクト
Route::post('/sendContact', 'SendContactController')
    ->name('sendContact');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
