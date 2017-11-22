<?php

namespace App\Http\Controllers\JinLi;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Input;

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
            $app = new Application(config('wechat'));
            $userInfo = $app->user->get($result['openid']);

            $salt = 'TOY-LOGIN' . time();
            $userInfo->token = strtoupper(md5('OPENID:' . $result['openid'] . $salt));

            return $this->respData($userInfo);
        } else {
            $this->respFail('code非法');
        }

        return $this->respData($result);

    }


}