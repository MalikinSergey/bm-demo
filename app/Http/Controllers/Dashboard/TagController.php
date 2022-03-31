<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $tags = Tag::all();

        return view('dashboard.tag.index', ['tags' => $tags]);
    }

    public function create()
    {
        return view('dashboard.tag.create', []);
    }

    public function store(Request $request)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'slug' => '', 'data' => '', 'position' => '', ],
        //    [],
        //    trans('tags.attributes')
        //);

        $tag = new Tag();

        /** @type Tag $tag */

        $tag->fill($request->all());

        $tag->save();

        return redirect()->route("dashboard.tag.index")->withMessage('common.success');
    }

    public function show(Request $request, $id)
    {
        $tag = Tag::find($id);

        /** @type Tag $tag */

        return view('dashboard.tag.show', ['tag' => $tag]);
    }

    public function edit($id)
    {
        $tag = Tag::find($id);

        /** @type Tag $tag */

        return view('dashboard.tag.edit', ['tag' => $tag]);
    }

    public function update(Request $request, $id)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'slug' => '', 'data' => '', 'position' => '', ],
        //    [],
        //    trans('tags.attributes')
        //);

        $tag = Tag::find($id);

        /** @type Tag $tag */

        $tag->fill(request()->all());

        $tag->save();

        return redirect()->route("dashboard.tag.edit", $tag->id)->withMessage('common.success');
    }

    public function destroy(Request $request, $id)
    {
        $tag = Tag::find($id);

        /** @type Tag $tag */

        $tag->delete();

        return redirect()->route("dashboard.tag.index")->withMessage('common.success');
    }

}
