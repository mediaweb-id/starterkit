<?php

namespace MediaWebId\Starterkit\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => getImage($this->image),
            'description' => $this->description,
            'position' => $this->position,
            'created_at'=> $this->created_at ? $this->created_at->format('d/m/Y H:i:s') : null ,

        ];
    }
}
