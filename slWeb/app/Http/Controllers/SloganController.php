<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentPost;
use App\Http\Requests\SloganDetailsPost;
use App\Http\Requests\SearchSlogansPost;
use App\Http\Requests\TagDetailPost;
use App\Slogan;
use App\Tag;
use Illuminate\Http\Request;

class SloganController extends Controller
{

//    /**
//     * トップページを表示する
//     *
//     * @param Request $request
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function getSlogans(Request $request)
//    {
//        $data = Slogan::with('comments')->orderByDesc('rating')->get();
//        return view('home', ['slogans' => $data]);
//    }

    /**
     *  全てのキャッチコピーを指定されたソート順で表示する
     *
     * @param $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOrderSlogans($order = null)
    {
        if ($order == null) {
            $data = Slogan::withCount('comments')->orderByDesc('rating')->paginate(3);
        } else {
            $data = Slogan::withCount('comments')->orderByDesc($order)->paginate(3);
        }
        return view('home', ['slogans' => $data]);
    }

    /**
     * 全てのタグを表示する
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTags(Request $request)
    {
        $data = Tag::withCount('slogans')->orderBy('slogans_count', 'desc')->get();
        return view('tag.tagList', ['tags' => $data]);
    }

    /**
     * タグに紐づくキャッチコピー一覧ページを表示する
     *
     * @param $tag_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sloganListByTagSearch($tag_id)
    {
        $tag = Tag::find($tag_id);
        $slogans = $tag->slogans()->get();
        return view('slogan.sloganList', ['slogans' => $slogans, 'query' => $tag->tag_name]);
    }

    /**
     * 検索結果を元にキャッチコピー一覧ページを表示する
     *
     * @param $keyword
     * @param $searchMethod
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchSlogans($keyword, $searchMethod)
    {
        $data = Slogan::withCount('comments')
            ->where($searchMethod, 'like', '%' . $keyword . '%')
            ->orderByDesc('rating')
            ->get();
        return view('slogan.sloganList', ['slogans' => $data]);
    }

    /**
     * スローガン作成用のページを表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inputSlogan()
    {
        return view('slogan.inputSlogan');
    }

    /**
     * キャッチコピーを1件追加する
     *
     * @param SloganDetailsPost $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSlogan(SloganDetailsPost $request)
    {
        $slogan = new Slogan();
        $slogan->fill($request->all())->save();

//        fwrite(STDERR, print_r($request->input('tags'), TRUE));
        $tagNames = $request->input('tagNames');
        if ($tagNames) {
            $tagNamesArray = explode("#", $tagNames);
            unset($tagNamesArray[0]);
            $tagIds = array();
            foreach ($tagNamesArray as $tagName) {
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                $tagIds[] = $tag->id;
//                fwrite(STDERR, print_r($tagIds, TRUE));
            }
            $slogan->tags()->attach($tagIds);
        }

        return redirect('/')->with('message', 'キャッチコピーを投稿しました。');
    }

    /**
     * slogan_idを元にキャッチコピー詳細ページを表示する
     *
     * @param $slogan_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSloganDetail($slogan_id)
    {
        $data = Slogan::findOrFail($slogan_id);
        return view('slogan.sloganDetail', ['slogan' => $data]);
    }

    /**
     * slogan_idを元にキャッチコピー編集ページを表示する
     *
     * @param $slogan_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editSlogan($slogan_id)
    {
        $data = Slogan::findOrFail($slogan_id);
        return view('slogan.editSlogan', ['slogan' => $data]);
    }

    /**
     * キャッチコピーを修正する
     *
     * @param SloganDetailsPost $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSloganDetail(SloganDetailsPost $request)
    {
        $sloganId = $request->input('id');
        $slogan = Slogan::find($sloganId);
        $slogan->fill($request->all())->save();

        $tagNames = $request->input('tagNames');
        if ($tagNames) {
            $tagNamesArray = explode("#", $tagNames);
            unset($tagNamesArray[0]);
            $tagIds = array();
            foreach ($tagNamesArray as $tagName) {
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $slogan->tags()->sync($tagIds);
        }

        $redirectParam = [
            'slogan_id' => $sloganId,
        ];
        return redirect(route('sloganDetail', $redirectParam))->with('message', 'キャッチコピーを修正しました');
    }

    /**
     * コメントを1件追加する
     *
     * @param CommentPost $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addComment(CommentPost $request)
    {
        $sloganId = $request->input('slogan_id');
        $slogan = Slogan::find($sloganId);
        $comment = new Comment();
        $comment->fill($request->all());
        $slogan->comments()->save($comment);

        // キャッチコピーの評価を修正
        $sumRating = $slogan->comments->sum('rating');
        $countRating = $slogan->comments->count();
        $slogan->rating = bcdiv($sumRating, $countRating, 1);
        $slogan->update();

        $redirectParam = [
            'slogan_id' => $sloganId,
        ];
//        fwrite(STDERR, print_r($redirectParam, TRUE));
        return redirect(route('sloganDetail', $redirectParam))->with('message', 'コメントを投稿しました。');
    }

//    /**
//     * タグを複数件追加する
//     *
//     * @param TagDetailPost $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function addTag(TagDetailPost $request)
//    {
//        $tag = new Tag();
//        $tag->fill($request->all())->save();
//
//        $sloganId = $request->input('slogan_id');
//        $tag->slogans()->attach($sloganId);
//
//        $redirectParam = [
//            'slogan_id' => $sloganId,
//        ];
//        return redirect(route('sloganDetail', $redirectParam))->with('message', 'コメントを投稿しました。');
//    }


    /**
     *  タグを検索する
     *
     * @param Request $request
     * @return string
     */
    public function searchTag(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Tag::where('tag_name', 'LIKE', "%{$query}%")->get();
            if ($data->isNotEmpty()) {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '<li><a href="#">' . $row->tag_name . '</a></li>';
                }
                $output .= '</ul>';
                return $output;
            }
        }
    }

}
