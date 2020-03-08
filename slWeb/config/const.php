<?php

return [
    // usersで使う定数
    'Users' => [
        'GENDER_NONE' => 0,
        'GENDER_MAN' => 1,
        'GENDER_WOMAN' => 2,
        'GENDER_LIST' => [
            'gender_none' => 0,
            'gender_man' => 1,
            'gender_woman' => 2,
        ],
    ],

    // 1ページの表示件数
    'PER_PAGE' => 10,

    // 検索結果画面に表示する最大文字数
    'SEARCH_RESULT_MAX_STR_NUM' => 30,
    // 検索条件の最大文字数
    'SEARCH_CONDITION_MAX_STR_NUM' => 50,

    // キャッチコピー最大入力文字数
    'SLOGAN_MAX_INPUT_NUM' => 50,
    // 作者最大入力文字数
    'WRITER_MAX_INPUT_NUM' => 15,
    // 出典最大入力文字数
    'SOURCE_MAX_INPUT_NUM' => 50,
    // 補足最大入力文字数
    'SUPPLEMENT_MAX_INPUT_NUM' => 1000,
    // タグ名最大入力文字数
    'TAG_NAME_MAX_INPUT_NUM' => 15,

    // コメント最大入力文字数
    'COMMENT_MAX_INPUT_NUM' => 300,
    // 投稿者最大入力文字数
    'CONTRIBUTOR_NAME_MAX_INPUT_NUM' => 30,

    // お問い合わせ最大入力文字数
    'INQUIRY_MAX_INPUT_NUM' => 1000,
];
