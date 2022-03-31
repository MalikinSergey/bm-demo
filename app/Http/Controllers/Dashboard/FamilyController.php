<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Family;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyController extends Controller
{

    public function index(Request $request)
    {
        $families = Family::query();

        if ($request->input('type')) {
            $families->where('type', $request->input('type'));
        }

        $families = $families->orderBy('id')->get();

        return view('dashboard.family.index', ['families' => $families]);
    }

    public function create()
    {
        return view('dashboard.family.create', []);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['name' => 'required', 'type' => 'required', 'status' => 'required'],
            [],
            trans('families.attributes')
        );

        $family = new Family();

        /** @type Family $family */

        $family->fill($request->all());

        $family->ensureSlug();

        $family->save();

        return redirect()->route("dashboard.family.index")->withMessage('common.success');
    }

    public function show(Request $request, $id)
    {
        $family = Family::find($id);

        /** @type Family $family */

        return view('dashboard.family.show', ['family' => $family]);
    }

    public function edit($id)
    {
        $family = Family::find($id);

        /** @type Family $family */

        return view('dashboard.family.edit', ['family' => $family]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => 'required', 'type' => 'required', 'status' => 'required'],
            [],
            trans('families.attributes')
        );

        $family = Family::find($id);

        /** @type Family $family */

        $family->fill(request()->all());

        $family->ensureSlug();

        $family->save();

        if ($request->hasFile('cover')) {
            $family->uploadCover($request->file('cover'));
        }

        return redirect()->route("dashboard.family.edit", $family->id)->withMessage('common.success');
    }

    public function destroy(Request $request, $id)
    {
        $family = Family::find($id);

        /** @type Family $family */

        $family->delete();

        return redirect()->route("dashboard.family.index")->withMessage('common.success');
    }

}
