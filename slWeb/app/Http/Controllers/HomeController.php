<?php

namespace App\Http\Controllers;

use App\Services\SloganService;

/**
 * Home画面を表示する
 *
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @param SloganService $sloganService
     * @param null $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(SloganService $sloganService, $order = null)
    {
        // 全てのキャッチコピーを指定されたソート順で取得
        $data = $sloganService->getAllSlogans($order);

        return view('home', ['slogans' => $data]);
    }
}
