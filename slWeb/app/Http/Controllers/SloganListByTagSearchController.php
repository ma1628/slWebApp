<?php

namespace App\Http\Controllers;

use App\Services\SloganService;

/**
 * タグに紐づくキャッチコピー一覧ページを表示する
 *
 * Class SloganListByTagSearchController
 * @package App\Http\Controllers
 */
class SloganListByTagSearchController extends Controller
{
    /**
     * @param $tag_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($tag_id, SloganService $sloganService)
    {
        list($tag, $slogans) = $sloganService->searchSlogansByTag($tag_id);
        return view('slogan.sloganListByTagSearch', ['slogans' => $slogans, 'tag' => $tag]);
    }
}
