<?php

namespace App\Http\Controllers\JinLi;

use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Models\JinLi\OcProduct;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function index()
    {
        $page = Input::get('page', 1);

        $cacheKey = CacheKey::HOME_PRODUCT_LIST . $page;
        $products = Redis::get($cacheKey);
        if (!empty($products)) {
            return $this->respData(json_decode($products, true));
        }

        $products = OcProduct::where('status', OcProduct::STATUS_COMMON_NORMAL)
                        ->select(
                            'product_id',
                            'model',
                            'price',
                            'viewed'
                        )
                        ->orderBy('sort_order', 'ASC')
                        ->paginate(self::DEFAULT_PER_PAGE);

        if (!empty($products)) {
            Redis::set($cacheKey, json_encode($products));
            Redis::expire($cacheKey, 1800);
        }

        return $this->respData($products);
    }


    public function sales()
    {

        $cacheKey = CacheKey::SALES_PRODUCT_LIST;
        $products = Redis::get($cacheKey);
        if (!empty($products)) {
            return $this->respData(json_decode($products, true));
        }

        $products = OcProduct::where('status', OcProduct::STATUS_COMMON_NORMAL)
                        ->select(
                            'product_id',
                            'model',
                            'price',
                            'viewed'
                        )
                        ->orderBy('viewed', 'asc')
                        ->limit(5)
                        ->get();

        if (!empty($products)) {
            Redis::set($cacheKey, json_encode($products));
            Redis::expire($cacheKey, 43200);
        }

        return $this->respData($products);
    }
}