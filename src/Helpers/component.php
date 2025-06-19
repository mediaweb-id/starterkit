<?php

use Illuminate\Support\Facades\Auth;

function components()
{
    $admin = auth('admin')->user();

    if ($admin && str(request()->path())->startsWith('backend')) {
        $components = [
            ['title' => 'Banner', 'value' => 'InputBanners'],
            ['title' => 'Card Slider', 'value' => 'InputCardSlider'],
            ['title' => 'Product Features', 'value' => 'InputProductFeatures'],
            ['title' => 'Latest Article', 'value' => 'InputLatestArticle'],
            ['title' => 'Call to Action', 'value' => 'InputCallToAction'],
            ['title' => 'Product Carousel', 'value' => 'InputProductCarousel'],
            ['title' => 'Two Colom', 'value' => 'InputTwoColom'],
        ];
        return $components;
    }
    return [];

}
