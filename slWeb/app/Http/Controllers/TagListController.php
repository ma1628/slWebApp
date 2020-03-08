<?php

namespace App\Http\Controllers;

use App\Services\TagService;

/**
 * タグ一覧画面を表示する
 *
 * Class TagListController
 * @package App\Http\Controllers
 */
class TagListController extends Controller
{
    /**
     * @param TagService $tagService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(TagService $tagService)
    {
        $data = $tagService->getAllTags();
        return view('tag.tagList', ['tags' => $data]);
    }
}
