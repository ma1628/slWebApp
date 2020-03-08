<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Auth;
use Illuminate\Http\Request;

/**
 * コメントを1件削除する（管理者向け）
 *
 * Class DeleteCommentController
 * @package App\Http\Controllers
 */
class DeleteCommentController extends Controller
{
    /**
     * @param Request $req
     * @param CommentService $commentService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function __invoke(Request $req, CommentService $commentService)
    {
        if (Auth::check()) {
            $commentService->deleteComment($req->input('comment_id'));
            return redirect(url()->previous())->with('message', 'コメントを1件削除しました。');
        }
        return redirect(url()->previous())->with('message', 'ログインしてください。');
    }

}
