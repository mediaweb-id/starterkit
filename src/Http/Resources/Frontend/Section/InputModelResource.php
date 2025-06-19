<?php

namespace App\Http\Resources\Frontend\Section;

use AcitJazz\Starterkit\Http\Resources\BaseResource;

class InputModelResource extends BaseResource
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
        $data = $this->resource;
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return [
           'title' => $data['title'] ?? null,
           'summary' => $data['summary'] ?? null,
        ];
    }
}
