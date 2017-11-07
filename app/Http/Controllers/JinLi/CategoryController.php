<?php

namespace App\Http\Controllers\JinLi;

use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Models\JinLi\OcCategory;
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
}