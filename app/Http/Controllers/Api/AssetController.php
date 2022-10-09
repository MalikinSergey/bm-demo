<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssetCollection;
use App\Mail\DownloadLinkMessage;
use App\Models\Asset;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('family_id')) {
            $family = Family::findOrFail($request->input('family_id'));

            $assets = $family->assets();

            $assets = $assets->paginate(24);

        } else {
            abort(404);
        }


        return new AssetCollection($assets);
    }

}
