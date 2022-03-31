<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Mail\DownloadLinkMessage;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Family;
use App\Models\Pack;

class TwoCheckoutController extends Controller
{

    public function ins(Request $request)
    {
        return ['success' => true];
    }

    public function ipn(Request $request)
    {
        \Log::info($request->all());

        $item = $request->input('IPN_EXTERNAL_REFERENCE.0');

        list($class, $itemID, $userID, $license) = explode("_", $item, 4);

        $user = \App\Models\User::find($userID);

        switch ($class) {
            case "asset":
                $asset = Asset::find($itemID);
                $user->assets()->save($asset, ['license' => $license]);
                \Mail::to([$user])->send(new DownloadLinkMessage($asset));
                break;
            case "pack":
                $pack = Pack::find($itemID);
                $user->packs()->save($pack, ['license' => $license]);
                \Mail::to([$user])->send(new DownloadLinkMessage($pack));
                break;
            case "family":
                $family = Family::find($itemID);
                $user->families()->save($family, ['license' => $license]);
                \Mail::to([$user])->send(new DownloadLinkMessage($family));
                break;
        }

        return ['success' => true];
    }

}