<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Pack;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {

        $landingFamilies = new Collection();

        $landingFamilies->push(Family::where('slug', 'innovicons')->first());
        $landingFamilies->push(Family::where('slug', 'metaphoricons')->first());
        $landingFamilies->push(Family::where('slug', 'highlighticons')->first());



        $landingPacks = Pack::orderBy('id', 'desc')->take(9)->get();

        return view('website.index', ['landingPacks' => $landingPacks, 'landingFamilies' => $landingFamilies]);
    }
}
