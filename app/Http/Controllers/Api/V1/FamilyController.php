<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FamilyResource;
use App\Models\Family;

class FamilyController extends Controller
{
    public function landing()
    {
        $families = Family::whereIn('slug', [
            'innovicons',
            'metaphoricons',
            'highlighticons'
        ])->get();

        return FamilyResource::collection($families);
    }

    public function show(string $familySlug)
    {
        $family = Family::whereSlug($familySlug)->firstOrFail();

        $family->load('assets');

        return FamilyResource::make($family);
    }
}