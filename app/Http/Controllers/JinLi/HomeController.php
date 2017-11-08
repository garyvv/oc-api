<?php

namespace App\Http\Controllers\JinLi;

use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function banner()
    {
        $layout = Input::get('layout', 'home');

        $images = [
            [
                'name' => 'name',
                'image' => 'http://toy.garylv.com/image/cache/catalog/Banner/bianxingjingang-1140x380.jpg',
                'target_id' => 1,
                'target' => 'product',
            ],
            [
                'name' => 'name',
                'image' => 'http://toy.garylv.com/image/cache/catalog/Banner/IMG_5545-1140x380.JPG',
                'target_id' => 1,
                'target' => 'product',
            ],
            [
                'name' => 'name',
                'image' => 'http://toy.garylv.com/image/cache/catalog/Banner/IMG_5548-1140x380.JPG',
                'target_id' => 1,
                'target' => 'product',
            ],
        ];

        return $this->respData($images);
    }
}