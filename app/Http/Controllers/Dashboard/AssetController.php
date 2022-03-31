<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Pack;
use App\Models\Tag;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Stringy\StaticStringy;

class AssetController extends Controller
{

    public function index(Request $request)
    {
        $assets = Asset::all();

        return view('dashboard.asset.index', ['assets' => $assets]);
    }

    public function create()
    {
        return view('dashboard.asset.create', []);
    }

    public function addMultiple($familyID)
    {
        $family = Family::findOrFail($familyID);

        return view('dashboard.asset.add_multiple', ['family' => $family]);
    }

    public function store(Request $request)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'type' => '', 'price' => '', 'slug' => '', 'data' => '', 'status' => 'required', 'position' => '', ],
        //    [],
        //    trans('assets.attributes')
        //);

        $asset = new Asset();

        /** @type Asset $asset */

        $asset->fill($request->all());

        $asset->save();

        return redirect()->route("dashboard.asset.index")->withMessage('common.success');
    }

    public function storeMultiple(Request $request)
    {
        $family = Family::findOrFail($request->family_id);

        $assetIds = [];

        foreach ($request->assets as $file) {
            /** @type UploadedFile $file */

            $asset = new Asset();

            $asset->fill($family->only('type'));

            $asset->name = Asset::suggestName($file->getClientOriginalName());

            $asset->slug = StaticStringy::slugify($file->getClientOriginalName());
            $asset->family_id = $family->id;
            $asset->save();

            $assetIds[] = $asset->id;

            if (!\Storage::disk('assets')->exists($family->id)) {
                \Storage::disk('assets')->makeDirectory($family->id);
            }

            \Storage::disk('assets')->putFileAs($family->id, $file, $asset->id);
        }

        $upload = new Upload();

        $upload->family_id = $family->id;

        $upload->save();

        $upload->assets()->attach($assetIds);

        return redirect()->route("dashboard.asset.edit_multiple", ['upload_id' => $upload->id])->withMessage('common.success');
    }

    public function updateMultiple(Request $request)
    {
        if ($request->delete_assets) {
            $upload = null;

            foreach ($request->input('selected_assets', []) as $id) {
                $asset = Asset::findOrFail($id);


                $asset->delete();
            }


        } else {
            foreach ($request->asset as $id => $data) {
                $asset = Asset::findOrFail($id);

                $asset->fill($data);

                $asset->slug = StaticStringy::slugify($asset->name);

                $asset->save();

                # tags

                $tagsLine = $data['tag_words'];

                $tagWords = explode(",", $tagsLine);

                $tagWords = array_filter($tagWords, fn($item) => trim($item) !== '');

                $tags = array_map(fn($tagWord) => Tag::firstOrCreate(['slug' => StaticStringy::slugify(trim($tagWord))], ['name' => strtolower(trim($tagWord))]), $tagWords);

                $tags = new Collection($tags);

                $asset->tags()->sync($tags);

                # packs

                $asset->packs()->sync(data_get($data, 'packs', []));
            }
        }

        return back()->withMessage('common.success');
    }

    protected function tagsFromName($file)
    {
        #
        $name = $file->getClientOriginalName();

        $name = explode(".", $name)[0];

        $tagNames = explode("-", $name);

        foreach ($tagNames as $tagName) {
            $tagSlug = StaticStringy::slugify($tagName);

            $tag = Tag::firstOrCreate(['slug' => $tagSlug], ['name' => $tagName]);
//            $tag->assets()->sync($asset);

        }
    }

    public function show(Request $request, $id)
    {
        $asset = Asset::find($id);

        /** @type Asset $asset */

        return view('dashboard.asset.show', ['asset' => $asset]);
    }

    public function edit($id)
    {
        $asset = Asset::find($id);

        /** @type Asset $asset */

        return view('dashboard.asset.edit', ['asset' => $asset]);
    }

    public function update(Request $request, $id)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'type' => '', 'price' => '', 'slug' => '', 'data' => '', 'status' => 'required', 'position' => '', ],
        //    [],
        //    trans('assets.attributes')
        //);

        $asset = Asset::find($id);

        /** @type Asset $asset */

        $asset->fill(request()->all());

        $asset->save();

        return redirect()->route("dashboard.asset.edit", $asset->id)->withMessage('common.success');
    }

    public function destroy(Request $request, $id)
    {
        $asset = Asset::find($id);

        /** @type Asset $asset */

        $asset->delete();

        return redirect()->route("dashboard.asset.index")->withMessage('common.success');
    }

    public function editMultiple(Request $request)
    {
        $source = null;
        if ($request->upload_id) {
            $source = 'upload';

            $upload = Upload::findOrFail($request->upload_id);
            $family = $upload->family;
            $assets = $upload->assets();
        } elseif ($request->family_id) {
            $source = 'family';

            $family = Family::findOrFail($request->family_id);

            $assets = $family->assets();
        } elseif ($request->pack_id) {
            $source = 'pack';

            $pack = Pack::findOrFail($request->pack_id);

            $family = $pack->family;

            $assets = $pack->assets();
        }

        $assets = $assets->orderBy('id', 'desc')->get();

        return view('dashboard.asset.edit_multiple', ['source' => $source, 'assets' => $assets, 'upload' => $upload ?? null, 'family' => $family ?? null, 'pack' => $pack ?? null]);
    }

    public function updateMultiplePrices(Request $request)
    {
        $source = null;

        if ($request->family_id) {
            $source = 'family';

            $family = Family::findOrFail($request->family_id);

            $assets = $family->assets();
        }

        $assets = $assets->get();

        foreach ($assets as $asset) {
            $request->price_personal ? $asset->update(['price_personal' => $request->price_personal]) : null;
            $request->price_commercial ? $asset->update(['price_commercial' => $request->price_commercial]) : null;
            $request->price_commercial_ext ? $asset->update(['price_commercial_ext' => $request->price_commercial_ext]) : null;
        }

        return back()->withMessage('common.success');
    }

}
