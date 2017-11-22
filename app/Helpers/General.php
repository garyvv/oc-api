<?php

/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/11/22
 * Time: 23:11
 */

namespace App\Helpers;

class General
{
    public static function Curl($url, $model = 'GET', $data = [], $header = [])
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $model);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            \Log::error("请求失败");
            \Log::error("Error: " . curl_error($ch));
        }

        curl_close($ch);
        return json_decode($result,true);
    }

    public static function getSign($params, $secret, $from = "")
    {
        //先进行字典排序
        ksort($params);
        $paramsSort = "";
        foreach ($params as $key => $value)
        {
            $paramsSort .= "$key=$value";
        }
        $sign = md5($paramsSort . $secret);
        return $sign;
    }

    public static function object2array($object) {
        $result =  json_decode( json_encode( $object),true);
        return  $result;
    }
}