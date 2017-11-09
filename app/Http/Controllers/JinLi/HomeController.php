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
        $cacheKey = CacheKey::HOME_BANNER_LIST . $layout;
        $banners = Redis::get($cacheKey);
        if ($banners) {
            return $this->respData(json_decode($banners, true));
        }

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

        if ($images) {
            Redis::set($cacheKey, json_encode($images));
        }

        return $this->respData($images);
    }

    public function keywords()
    {
        $cacheKey = CacheKey::HOME_KEYWORD_LIST;
        $keywords = Redis::get($cacheKey);
        if ($keywords) {
            return $this->respData(json_decode($keywords, true));
        }

        $keywords = [
            [
                [
                    'name' => '儿童车',
                    'category_id' => 4,
                ]
            ],
            [
                [
                    'name' => '气球',
                    'category_id' => 4,
                ],
                [
                    'name' => '水枪',
                    'category_id' => 4,
                ],
            ],
            [
                [
                    'name' => '学步车',
                    'category_id' => 4,
                ],
                [
                    'name' => '儿童椅',
                    'category_id' => 4,
                ],
                [
                    'name' => '儿童车',
                    'category_id' => 4,
                ],
            ],
            [
                [
                    'name' => '学步车',
                    'category_id' => 4,
                ],
                [
                    'name' => '儿童椅',
                    'category_id' => 4,
                ],
                [
                    'name' => '儿童车',
                    'category_id' => 4,
                ],
                [
                    'name' => '儿童车',
                    'category_id' => 4,
                ],
            ],
            [
                [
                    'name' => '儿童车',
                    'category_id' => 4,
                ],

            ],
        ];

        if ($keywords) {
            Redis::set($cacheKey, json_encode($keywords));
        }

        return $this->respData($keywords);
    }
}