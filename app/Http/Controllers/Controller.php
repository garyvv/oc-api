<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $validateRules = [
        'page' => 'numeric|nullable|max:10000',
        'limit' => 'numeric|nullable|max:100',
    ];

    public function __construct()
    {
        $this->requestValidate($this->validateRules);
    }

    //
    protected function respData($data, $msg = '操作成功')
    {
        $result = [
            'code' => 200,
            'data' => $data,
            'msg' => $msg,
        ];
        return response()->json($result);
    }
    protected function respMsg($code = 200, $msg = '操作成功')
    {
        $result = [
            'code' => $code,
            'data' => [],
            'msg' => $msg,
        ];
        return response()->json($result, $code);
    }
    protected function respSuccess($msg = '操作成功')
    {
        return $this->respMsg(200, $msg);
    }
    protected function respFail($msg = '操作失败')
    {
        return $this->respMsg(500, $msg);
    }

    protected function requestValidate($rules, $message = [])
    {
        $validate = Validator::make(Input::all(), $rules, $message);

        if ($validate->fails()) {
            throw new \Exception($validate->getMessageBag()->first(), Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
