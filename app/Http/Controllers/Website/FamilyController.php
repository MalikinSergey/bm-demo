<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\DownloadLinkMessage;
use App\Models\Asset;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{

    public function index()
    {
        $families = Family::active()->icons()->get();
        return view('website.family.index', ['families' => $families]);
    }

    public function illustrations()
    {
        $families = Family::illustrations()->active()->get();

        return view('website.family.index', ['families' => $families]);
    }

    public function show($familySlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $assets = $family->assets;

        return view('website.family.show', ['family' => $family, 'assets' => $assets]);
    }

    public function buy(Request $request, $familySlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        if (!auth()->check()) {
            return redirect()->route('website.user.register_form', ['from_url' => $family->url(), 'from_title' => $family->name]);
        }

        $license = $request->input('license_type');

        auth()->user()->families()->save($family, ['license' => $license]);

        \Mail::to([auth()->user()])->send(new DownloadLinkMessage($family));

        return back()->withMessage(trans('purchases.messages.success'));
    }

    public function download($familySlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        if (!auth()->check() || !$family->users->contains(auth()->user())) {
            abort(403);
        }

        $family->createArchive();

        return \Storage::disk('downloads')
            ->download(
                $family->downloadPath(),
                $family->downloadName(),
                ['Content-Disposition' => 'attachment; filename="' . $family->downloadName() . '"']
            );
    }
}
