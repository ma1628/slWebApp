<?php

namespace App\Http\Controllers;

use App\Services\SloganService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 検索結果を元にキャッチコピー一覧ページを表示する
 *
 * Class SloganListController
 * @package App\Http\Controllers
 */
class SloganListController extends Controller
{
    /**
     * @param Request $req
     * @param SloganService $sloganService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $req, SloganService $sloganService)
    {
        $validatedData = $req->validate([
            'keyword' => 'required',
            'searchMethod' => ['regex:/^phrase$|^writer$|^source$/'],
        ]);

        //値を取得
        $keyword = $req->input('keyword');
        $searchMethod = $req->input('searchMethod');

        $data = $sloganService->searchSlogans($searchMethod, $keyword);

        $params = [
            "keyword" => $keyword,
            "searchMethod" => $searchMethod
        ];

        return view('slogan.sloganList', ['slogans' => $data, 'params' => $params]);
    }
}
