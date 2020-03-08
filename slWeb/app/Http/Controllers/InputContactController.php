<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * お問い合わせページを表示する
 *
 * Class InputContactController
 * @package App\Http\Controllers
 */
class InputContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('contact.inputContact');
    }
}
