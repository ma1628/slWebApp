<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > タグ一覧
Breadcrumbs::for('tagList', function ($trail) {
    $trail->parent('home');
    $trail->push('タグ一覧', route('tagList'));
});

// Home > タグ検索結果
Breadcrumbs::for('sloganListByTagSearch', function ($trail, $tag) {
    $trail->parent('tagList');
    $trail->push('#'.$tag->tag_name, route('sloganListByTagSearch',$tag->id));
});

// Home > 検索結果
Breadcrumbs::for('sloganList', function ($trail, $keyword) {
    $trail->parent('home');
    $trail->push('検索結果:'.$keyword, route('sloganList',$keyword));
});

// Home > キャッチコピー追加
Breadcrumbs::for('inputSlogan', function ($trail) {
    $trail->parent('home');
    $trail->push('キャッチコピー追加', route('inputSlogan'));
});

// Home > キャッチコピー詳細
Breadcrumbs::for('sloganDetail', function ($trail, $slogan) {
    $trail->parent('home');
    $trail->push(mb_substr( $slogan->phrase, 0, 10, 'utf-8' ).'...', route('sloganDetail',$slogan->id));
});

// Home > キャッチコピー詳細 > キャッチコピー編集
Breadcrumbs::for('editSlogan', function ($trail, $slogan) {
    $trail->parent('sloganDetail',$slogan);
    $trail->push('編集', route('editSlogan',$slogan->id));
});
//
//// Home > Blog > [Category]
//Breadcrumbs::for('category', function ($trail, $category) {
//    $trail->parent('blog');
//    $trail->push($category->title, route('category', $category->id));
//});
//
//// Home > Blog > [Category] > [Post]
//Breadcrumbs::for('post', function ($trail, $post) {
//    $trail->parent('category', $post->category);
//    $trail->push($post->title, route('post', $post->id));
//});
