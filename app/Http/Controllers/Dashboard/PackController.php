<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Family;
use App\Models\Pack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stringy\StaticStringy;

class PackController extends Controller
{

    public function index(Request $request)
    {
        $family = Family::findOrFail($request->family_id);

        $packs = $family->packs;

        return view('dashboard.pack.index', ['packs' => $packs, 'family' => $family]);
    }

    public function create()
    {
        return view('dashboard.pack.create', []);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['name' => 'required'],
            [],
            trans('packs.attributes')
        );

        $family = Family::findOrFail($request->family_id);

        $pack = new Pack();

        /** @type Pack $pack */

        $pack->fill($request->only('name', 'price_personal', 'price_commercial', 'price_commercial_ext', 'slug', 'status'));

        $pack->family_id = $family->id;

        $pack->type = $family->type;

        $pack->ensureSlug();

        $pack->save();

        return redirect()->route("dashboard.pack.index", ['family_id' => $pack->family_id])->withMessage('common.success');
    }

    public function show(Request $request, $id)
    {
        $pack = Pack::find($id);

        /** @type Pack $pack */

        return view('dashboard.pack.show', ['pack' => $pack]);
    }

    public function edit($id)
    {
        $pack = Pack::find($id);

        /** @type Pack $pack */

        return view('dashboard.pack.edit', ['pack' => $pack]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => 'required'],
            [],
            trans('packs.attributes')
        );

        $pack = Pack::find($id);

        /** @type Pack $pack */

        $pack->fill(request()->all());

        $pack->ensureSlug();

        $pack->save();

        return redirect()->route("dashboard.pack.edit", $pack->id)->withMessage('common.success');
    }

    public function destroy(Request $request, $id)
    {
        $pack = Pack::find($id);

        /** @type Pack $pack */

        $pack->delete();

        return redirect()->route("dashboard.pack.index")->withMessage('common.success');
    }

}
