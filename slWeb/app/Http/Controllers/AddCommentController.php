<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPost;
use App\Services\CommentService;

/**
 * コメントを1件追加する
 *
 * Class AddCommentController
 * @package App\Http\Controllers
 */
class AddCommentController extends Controller
{
    /**
     * @param CommentPost $request
     * @param CommentService $commentService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function __invoke(CommentPost $request, CommentService $commentService)
    {
        $sloganId = $request->input('slogan_id');
        $commentService->insertComment($request->all());
        $redirectParam = [
            'slogan_id' => $sloganId,
        ];
        return redirect(route('sloganDetail', $redirectParam))
            ->with('message', 'コメントを投稿しました。');
    }
}
