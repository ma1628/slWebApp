<?php

namespace App\Http\Controllers;

use App\Services\SloganService;
use App\Slogan;

/**
 * slogan_idを元にキャッチコピー編集ページを表示する
 *
 * Class EditSloganController
 * @package App\Http\Controllers
 */
class EditSloganController extends Controller
{
    /**
     * @param $slogan_id
     * @param SloganService $sloganService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($slogan_id,SloganService $sloganService)
    {
        $data = $sloganService->getSlogan($slogan_id);
        return view('slogan.editSlogan', ['slogan' => $data]);
    }
}
