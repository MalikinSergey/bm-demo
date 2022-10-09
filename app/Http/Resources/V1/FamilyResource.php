<?php

namespace App\Http\Resources\V1;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Family */
class FamilyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'type_plural' => $this->type_plural,
            'slug' => $this->slug,
            'assets_count' => $this->assets->count(),
            'packs_count' => $this->packs->count(),
            'price_personal' => $this->getPrice('personal'),
            'assets' => AssetResource::collection($this->whenLoaded('assets')),
            'highlight_assets' => AssetResource::collection($this->assets()->orderByRaw('position asc nulls last')->take(8)->get())
        ];
    }
}
