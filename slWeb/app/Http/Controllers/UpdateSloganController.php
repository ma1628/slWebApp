<?php

namespace App\Http\Controllers;

use App\Http\Requests\SloganDetailsPost;
use App\Services\SloganService;

/**
 * キャッチコピーを修正する
 *
 * Class UpdateSloganController
 * @package App\Http\Controllers
 */
class UpdateSloganController extends Controller
{
    /**
     * @param SloganDetailsPost $request
     * @param SloganService $sloganService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function __invoke(SloganDetailsPost $request, SloganService $sloganService)
    {
        $sloganId = $request->input('slogan_id');
        $sloganService->updateSlogan($request->all());
        $redirectParam = [
            'slogan_id' => $sloganId,
        ];
        return redirect(route('sloganDetail', $redirectParam))->with('message', 'キャッチコピーを修正しました');
    }

}
