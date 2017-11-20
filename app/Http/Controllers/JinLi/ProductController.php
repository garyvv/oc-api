<?php

namespace App\Http\Controllers\JinLi;

use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Models\JinLi\OcProduct;
use DiDom\Document;
use Illuminate\Support\Facades\DB;
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
                            DB::raw('CONCAT("详细信息: ", model) AS description'),
                            'image',
                            'price',
                            'viewed'
                        )
                        ->orderBy('sort_order', 'ASC')
                        ->paginate(self::DEFAULT_PER_PAGE);

        if (!empty($products)) {
            Redis::set($cacheKey, json_encode($products));
            Redis::expire($cacheKey, 3600);
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
                            DB::raw('CONCAT("详细信息: ", model) AS description'),
                            'image',
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


    public function detail($productId)
    {
        $cacheKey = CacheKey::PRODUCT_DETAIL . $productId;
        $product = Redis::get($cacheKey);
        if (!empty($product)) {
            return $this->respData(json_decode($product, true));
        }

        $product = OcProduct::getProduct($productId);

        if ($product->category)
            $product->category = array_unique(explode(',', $product->category));
        else
            $product->category = [];


        if ($product->images)
            $product->images = array_unique(explode(',', $product->images));
        else
            $product->images = ["/images/common/index-toy.png"];

        $html = $product->title;
        if ($product->description && strpos($product->description, 'http') !== false) {
            $html = new Document($product->description, true);
            $content = $html->find('body');
            $html = $content[0]->html();
        }
        $product->description = $html;


        if (!empty($product)) {
            Redis::set($cacheKey, json_encode($product));
            Redis::expire($cacheKey, 3600);
        }

        return $this->respData($product);
    }

}