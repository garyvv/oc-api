<?php

namespace App\Services\JinLi;
use App\Libraries\CacheKey;
use App\Models\JinLi\ToyUser;
use App\Services\BaseService;
use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/11/23
 * Time: 00:36
 */
class UserService extends BaseService
{
    public static function getUserInfo($uid)
    {
        $cacheKey = CacheKey::USER_INFO . $uid;
        $userInfo = Redis::get($cacheKey);
        if (!empty($userInfo)) {
            return json_decode($userInfo, true);
        }

        $userInfo = ToyUser::find($uid);

        if (!empty($userInfo)) {
            Redis::set($cacheKey, json_encode($userInfo));
            Redis::expire($cacheKey, 86400);
        }

        return $userInfo;
    }


}