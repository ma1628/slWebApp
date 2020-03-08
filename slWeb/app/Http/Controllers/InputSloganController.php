<?php

namespace App\Http\Controllers;

/**
 * スローガン作成用のページを表示
 *
 * Class InputSloganController
 * @package App\Http\Controllers
 */
class InputSloganController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('slogan.inputSlogan');
    }
}
