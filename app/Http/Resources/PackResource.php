<?php

namespace App\Http\Resources;

use App\Models\Pack;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 *
 */
class PackResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Pack
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $pack = $this->resource;

        return [
            'name' => $pack->name,
            'slug' => $pack->slug,
            'type' => $pack->type,
            'url' => $pack->url(),
            'preview_assets' => $this->previewAssets(),
            'price_personal' => $pack->getPrice('personal'),
            'discount_percent' => $pack->getDiscountPercent(),
            'count_assets_text' => $this->countAssetsText(),
        ];
    }

    public function previewAssets(): AssetCollection{
        $pack = $this->resource;
        return new AssetCollection($pack->assets()->take($pack->family->type === 'icon' ? 6 : 1)->get());
    }

    public function countAssetsText(): string
    {
        $pack = $this->resource;

        if ($pack->family->type === 'icon') {
            return trans_choice(':count icon|:count icons', $pack->assets->count());
        } else {
            return trans_choice(':count illustration|:count illustrations', $pack->assets->count());
        }
    }
}
