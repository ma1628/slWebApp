<?php

namespace App\Http\Controllers;

use App\Services\SloganService;

/**
 * slogan_idを元にキャッチコピー詳細ページを表示する
 *
 * Class SloganDetailController
 * @package App\Http\Controllers
 */
class SloganDetailController extends Controller
{
    /**
     * @param $slogan_id
     * @param SloganService $sloganService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($slogan_id, SloganService $sloganService)
    {
        $data = $sloganService->getSlogan($slogan_id);

        return view('slogan.sloganDetail', ['slogan' => $data]);
    }
}
