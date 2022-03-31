<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Pack;
use App\Models\Tag;
use Illuminate\Http\Request;
use Stringy\StaticStringy;

class SearchController extends Controller
{

    public function searching(Request $request)
    {
        $query = $request->input('query');

        session()->put('search_query', $query);

        $query = StaticStringy::toLowerCase($query);

//        $pattern = "/[^a-zA-ZА-Яа-я\d\s\-_]/u";
//
//        $query = preg_replace($pattern, '-', $query);
        $query = StaticStringy::delimit($query, "-");

//        dd($query);

        return redirect()->route('website.search.search', $query);
    }

    public function search(Request $request, $query)
    {

        $realQuery =  session()->get('search_query');

        $query = StaticStringy::toLowerCase($query);

        $query = str_replace("-", " ", $query);


        if(!$realQuery){
            $realQuery = $query;
        }

//        $tags = Tag::where('name', 'like', $query)->get();

//        $tagsIDs = $tags->pluck('id');

//        dd($tagsIDs);

//        dd($tags);


        # icons

        $icons = Asset::query()->typeOf('icon');

        $icons->whereRaw('search_content @@ plainto_tsquery(\'english\', ?)', [$query])
            ->orderByRaw('ts_rank(search_content, plainto_tsquery(\'english\', ?)) DESC', [$query]);

        $icons = $icons->get();

        $iconPacks = Pack::query()->typeOf('icon');

        $iconPacks->whereRaw('search_content @@ plainto_tsquery(\'english\', ?)', [$query])
            ->orderByRaw('ts_rank(search_content, plainto_tsquery(\'english\', ?)) DESC', [$query]);

        $iconPacks = $iconPacks->get();

        # illustrations

        $illustrations = Asset::query()->typeOf('illustration');

        $illustrations->whereRaw('search_content @@ plainto_tsquery(\'english\', ?)', [$query])
            ->orderByRaw('ts_rank(search_content, plainto_tsquery(\'english\', ?)) DESC', [$query]);

        $illustrations = $illustrations->get();


        $illustrationPacks = Pack::query()->typeOf('illustration');

        $illustrationPacks->whereRaw('search_content @@ plainto_tsquery(\'english\', ?)', [$query])
            ->orderByRaw('ts_rank(search_content, plainto_tsquery(\'english\', ?)) DESC', [$query]);

        $illustrationPacks = $illustrationPacks->get();


        return view('website.search.search', ['icons' => $icons, 'iconPacks' => $iconPacks,'illustrations' => $illustrations, 'illustrationPacks' => $illustrationPacks, 'query' => $query, 'realQuery' => $realQuery]);
    }
}
