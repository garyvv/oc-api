<?php

namespace App\Http\Controllers\JinLi;

use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Models\JinLi\OcCategory;
use App\Models\JinLi\OcProduct;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    public function index()
    {
        $cacheKey = CacheKey::TAB_BAR_CATEGORIES;
        if (!$categories = Redis::get($cacheKey)) {
            $categories = OcCategory::getTabbarCategories();
            if (!empty($categories)) {
                Redis::set($cacheKey, json_encode($categories));
            }
        } else {
            $categories = json_decode($categories, true);
        }

        return $this->respData($categories);
    }


    public function products($categoryId)
    {
        $page = Input::get('page', 1);

        $cacheKey = CacheKey::CATEGORIES_LIST_PRODUCT . $categoryId . ':PAGE:' . $page;

        $products = Redis::get($cacheKey);
        if ($products) {
            return $this->respData(json_decode($products, true));
        }

        $products = OcProduct::getProductsByCategoryId($categoryId);
        $products = json_decode(json_encode($products), true);

        if ($products['data']) {
            foreach ($products['data'] as $key => $product)
            {
                if ($product['photos']) $products['data'][$key]['photos'] = explode(',', $product['photos']);
                else $products['data'][$key]['photos'] = ['/images/common/index-toy.png'];
            }

            Redis::set($cacheKey, json_encode($products));
            Redis::expire($cacheKey, 3600);
        }

        return $this->respData($products);
    }


}