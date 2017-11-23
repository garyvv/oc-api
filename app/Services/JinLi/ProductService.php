<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/11/23
 * Time: 14:36
 */

namespace App\Services\JinLi;
use App\Helpers\General;
use App\Libraries\CacheKey;
use App\Services\BaseService;
use Illuminate\Support\Facades\Redis;

class ProductService extends BaseService
{
    public static function formatData($products)
    {

        $tmpTime = '';
        foreach ($products as $key => &$product)
        {
            $product['time_pass'] = date('H:i', strtotime($product['view_time']));//General::formatTime($product['view_time']);

            $product['time_group'] = General::formatTimeGroup($product['view_time'], $tmpTime);

        }
        return $products;
    }


}