<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\DownloadLinkMessage;
use App\Models\Asset;
use App\Models\Family;
use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{

    public function show($familySlug, $packSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $pack = $family->packs()->whereSlug($packSlug)->firstOrFail();

        $assets = $pack->assets;

        return view('website.pack.show', ['pack' => $pack, 'assets' => $assets]);
    }

    public function buy(Request $request, $familySlug, $packSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $pack = $family->packs()->whereSlug($packSlug)->firstOrFail();

        if (!auth()->check()) {
            return redirect()->route('website.user.register_form', ['from_url' => $family->url(), 'from_title' => $family->name]);
        }

        $license = $request->input('license_type');

        auth()->user()->packs()->save($pack, ['license' => $license]);

        \Mail::to([auth()->user()])->send(new DownloadLinkMessage($family));

        return back()->withMessage(trans('purchases.messages.success'));
    }

    public function download($familySlug, $packSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $pack = $family->packs()->whereSlug($packSlug)->firstOrFail();

        if (!auth()->check() || !$pack->hasLicense(auth()->user())) {
            abort(403);
        }

        $pack->createArchive();

        return \Storage::disk('downloads')
            ->download(
                $pack->downloadPath(),
                $pack->downloadName(),
                ['Content-Disposition' => 'attachment; filename="' . $pack->downloadName() . '"']
            );
    }
}
