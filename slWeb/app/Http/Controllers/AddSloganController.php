<?php

namespace App\Http\Controllers;

use App\Http\Requests\SloganDetailsPost;
use App\Services\SloganService;

/**
 * キャッチコピーを1件追加する
 *
 * Class AddSloganController
 * @package App\Http\Controllers
 */
class AddSloganController extends Controller
{
    /**
     * @param SloganDetailsPost $request
     * @param SloganService $sloganService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function __invoke(SloganDetailsPost $request, SloganService $sloganService)
    {
        $sloganService->insertSlogan($request->all());
        return redirect(route('home'))->with('message', 'キャッチコピーを投稿しました。');
    }
}
