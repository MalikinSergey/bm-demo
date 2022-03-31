<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\DownloadLinkMessage;
use App\Models\Asset;
use App\Models\Family;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function inline($familySlug, $assetSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $asset = $family->assets()->whereSlug($assetSlug)->firstOrFail();

        $source = response()->make(\Storage::disk('assets')->get($asset->path()), 200, ['Content-Type' => 'image/svg+xml']);

        return $source;



//        $wm = '<style type="text/css">
//    text { fill: gray; font-family: Avenir; }
//</style>
//    <defs>
//        <pattern id="twitterhandle" patternUnits="userSpaceOnUse" width="400" height="200">
//            <text y="30" font-size="40" id="name">boykomarket</text>
//        </pattern>
//        <pattern id="combo" xlink:href="#twitterhandle" patternTransform="rotate(-45)">
//              <use xlink:href="#name" />
//        </pattern>
//    </defs>
//<rect width="100%" height="100%" fill="url(#combo)" />';
//
//$source = str_replace()



    }

    public function show($familySlug, $assetSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $asset = $family->assets()->whereSlug($assetSlug)->firstOrFail();

        return view('website.asset.show', ['asset' => $asset]);
    }

    public function buy(Request $request, $familySlug, $assetSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $asset = $family->assets()->whereSlug($assetSlug)->firstOrFail();

        if (!auth()->check()) {
            return redirect()->route('website.user.register_form', ['from_url' => $family->url(), 'from_title' => $family->name]);
        }

        $license = $request->input('license_type');

        $paymentLink = $asset->paymentLink($license, user()->id);

//        dd($paymentLink);

        return redirect($paymentLink);



//        auth()->user()->assets()->save($asset, ['license' => $license]);

//        \Mail::to([auth()->user()])->send(new DownloadLinkMessage($asset));

//        return back()->withMessage(trans('purchases.messages.success'));
    }

    public function download($familySlug, $assetSlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $asset = $family->assets()->whereSlug($assetSlug)->firstOrFail();

        if (!auth()->check() || !$asset->hasLicense(auth()->user())) {
            abort(403);
        }

        $asset->createArchive();

        return \Storage::disk('downloads')
            ->download(
                $asset->downloadPath(),
                $asset->downloadName(),
                ['Content-Disposition' => 'attachment; filename="' . $asset->downloadName() . '"']
            );
    }

}
