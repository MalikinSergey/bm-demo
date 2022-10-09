<?php

namespace App\Http\Resources\V1;

use App\Models\Asset;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Asset
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $asset = $this->resource;

       return [
           'name' => $asset->name,
           'type' => $asset->type,
           'slug' => $asset->slug,
           'preview_url_w128' => $asset->previewUrl(128),
           'preview_url_w512' => $asset->previewUrl(512),
           'preview_86' => $asset->previewUrl(86),
           'preview_320' => $asset->previewUrl(320),
       ];
    }
}
