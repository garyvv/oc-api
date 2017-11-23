<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/11/23
 * Time: 00:41
 */

namespace App\Http\Controllers\JinLi\Auth;


use App\Helpers\General;
use App\Models\JinLi\ToyUser;
use App\Models\JinLi\ToyUserView;
use App\Services\JinLi\ProductService;
use Illuminate\Support\Facades\Input;

class UserController extends AuthController
{
    public function edit()
    {
        $user = ToyUser::find($this->uid);
        $user->nickname = Input::get('nickname', $user->nickname);
        $user->gender   = Input::get('gender', $user->gender);
        $user->avatar   = Input::get('avatar', $user->avatar);
        $user->country  = Input::get('country', $user->country);
        $user->province = Input::get('province', $user->province);
        $user->city     = Input::get('city', $user->city);
        $user->mobile   = Input::get('mobile', $user->mobile);
        $user->language = Input::get('language', $user->language);

        $user->save();

        return $this->respData($user);
    }

    public function viewHistory()
    {
        $histories = ToyUserView::getUserViewHistory($this->uid);

        $histories = General::object2array($histories);
        $histories = ProductService::formatData($histories);

        return $this->respData($histories);
    }

}