<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NfeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        $this->resource->xml = route('nfe.show', ['access_key' => $this->access_key]);
        return parent::toArray($request);
    }
}
