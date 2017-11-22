<?php
namespace App\Http\Controllers\JinLi\Auth;
use App\Http\Controllers\Controller;
use App\Libraries\CacheKey;
use App\Services\JinLi\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public $token;
    public $uid;
    public $userInfo;

    const API_CODE_TOKEN_ERROR = 2001;// token失效

    public function __construct(Request $request)
    {
        $token = $request->header('token', null);
        $uid = $request->header('uid', null);

        if (empty($uid)) {
            throw new \Exception('uid missing', self::API_CODE_TOKEN_ERROR);
        }

        if (empty($token)) {
            throw new \Exception('token missing', self::API_CODE_TOKEN_ERROR);
        }

        $session = json_decode(Redis::get(CacheKey::WECHAT_SESSION . $token), true);

        if (empty($session)) {
            throw new \Exception('token error', self::API_CODE_TOKEN_ERROR);
        }

        if (!isset($session['uid']) || intval($session['uid']) !== intval($uid)) {
            throw new \Exception('token error !', self::API_CODE_TOKEN_ERROR);
        }

        $this->uid = $session['uid'];
        $this->userInfo = UserService::getUserInfo($session['uid']);

        if (empty($this->userInfo)) {
            throw new \Exception('user not found !', self::API_CODE_TOKEN_ERROR);
        }
    }
}