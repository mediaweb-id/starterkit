<?php

namespace AcitJazz\Starterkit\Http\Resources\Frontend;

use AcitJazz\Starterkit\Http\Resources\BaseResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputBannersResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputCallToActionResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputCardSliderResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputLatestNewsResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputProductFeaturesResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputProductCarouselResource;
use AcitJazz\Starterkit\Http\Resources\Frontend\Section\InputModelResource;

class SectionResource extends BaseResource
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
        if (is_null($this->data)) {
            $data = [];
        }
        switch ($this->type) {
            case 'InputBanners':
                $data = InputBannersResource::collection($this->data)->resolve();
                break;
            case 'InputCardSlider':
                $data = InputCardSliderResource::make($this->data)->resolve();
                break;
            case 'InputProductFeatures':
                $data = InputModelResource::make($this->data)->resolve();
                break;
            case 'InputTwoColom':
                $data = InputProductFeaturesResource::make($this->data)->resolve();
                break;
            case 'InputLatestNews':
                $data = InputLatestNewsResource::make($this->data)->resolve();
                break;
            case 'InputCallToAction':
                $data = InputCallToActionResource::make($this->data)->resolve();
                break;
            case 'InputProductCarousel':
                $data = InputProductCarouselResource::make($this->data)->resolve();
                break;
            case 'InputLogo':
                $data = InputModelResource::make($this->data)->resolve();
                break;
            default:
                $data = $this->data;
                break;
        }

        return [
           'id' => $this->id,
           'data' => $data,
           'show' => $this->show,
           'type' => str_replace('Input', '', $this->type),
        ];
    }
}
