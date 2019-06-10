<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostalCodeState
 * @package App\Http\Resources
 */
class PostalCodeState extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $hasTowns = property_exists($this->resource, 'towns');
        $towns = $hasTowns ? $this->resource->towns : [];

        return [
            'id'    => $this->resource->state_key,
            'name'  => $this->resource->state_name,
            'towns' => $this->when($hasTowns, $this->includeTowns())
        ];
    }

    private function includeTowns()
    {
        return function () {
            return PostalCodeTown::collection($this->resource->towns);
        };
    }
}
