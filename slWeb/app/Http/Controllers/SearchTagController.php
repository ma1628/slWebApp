<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use App\Tag;
use Illuminate\Http\Request;

/**
 * タグを検索する
 * Class SearchTagController
 * @package App\Http\Controllers
 */
class SearchTagController extends Controller
{
    /**
     * @param Request $request
     * @param TagService $tagService
     * @return string
     */
    public function __invoke(Request $request, TagService $tagService)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = $tagService->searchTags($query);
            if ($data->isNotEmpty()) {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '<li class="tag_li"><a href="#">' . $row->tag_name . '</a></li>';
                }
                $output .= '</ul>';
                return $output;
            }
        }
    }
}
