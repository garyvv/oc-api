<?php

namespace App\Http\Controllers\JinLi;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Models\JinLi\ToyUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function login()
    {
        $this->requestValidate([
            'code' => 'required'
        ]);

        $appId = config('wechat.app_id');
        $appSecret = config('wechat.secret');
        $code = Input::get('code');

        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appId . '&secret=' . $appSecret . '&js_code=' . $code . '&grant_type=authorization_code';

        $result = General::Curl($url);

        if (isset($result['openid'])) {
            $user = ToyUser::where('openid', $result['openid'])->first();
            if (empty($user)) {
                $user = new ToyUser();
                $user->openid = $result['openid'];
                $user->save();
            }

            $data = [];
            $salt = 'TOY-LOGIN' . time();
            $data['token'] = strtoupper(md5('OPENID:' . $result['openid'] . $salt));

//            保持登录状态
            $cacheKey = CacheKey::WECHAT_SESSION . $data['token'];
            $cacheData = [
                'open_id' => $result['openid'],
                'uid' => $user->id,
            ];
            Redis::set($cacheKey, json_encode($cacheData));
            Redis::expire($cacheKey, 86400 * 30); // 保持30日登录状态

            $data['uid'] = $user->id;
            return $this->respData($data);
        } else {
            return $this->respFail('code非法');
        }


    }


}