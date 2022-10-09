<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackCollection;
use App\Mail\DownloadLinkMessage;
use App\Models\Asset;
use App\Models\Family;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PackController extends Controller
{

    public function index(Request $request)
    {
        if ($request->input('family_id')) {
            $family = Family::findOrFail($request->input('family_id'));

            $packs = $family->packs();

            $packs = $packs->paginate(6);

        } else {
            abort(404);
        }

        return new PackCollection($packs);
    }


}
