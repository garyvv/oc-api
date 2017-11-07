<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{

    //
    protected function respData($data = [], $msg = '操作成功')
    {
        $result = [
            'code'      => Response::HTTP_OK,
            'success'   => true,
            'data'      => $data,
            'msg'       => $msg
        ];
        return response()->json($result, Response::HTTP_OK);
    }


    protected function respFail($msg = '操作失败', $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        throw new \Exception($msg, $code);
    }


    protected function requestValidate($rules, $message)
    {
        $validate = Validator::make(Input::all(), $rules, $message);

        if ($validate->fails()) {
            throw new \Exception($validate->getMessageBag()->first(), Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}