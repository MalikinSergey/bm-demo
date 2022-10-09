<?php

namespace App\Http\Resources;

use App\Models\Pack;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class PackCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = PackResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
