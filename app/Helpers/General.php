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

    public static function formatTimeGroup($dateTime, &$tmpTime, $str = 'm/d')
    {

        $todayTime = strtotime('today');
        $yesterdayTime = mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));

        $time = strtotime(date('Y-m-d', strtotime($dateTime)));

        if ($time == $todayTime) {
            $result = '今天';
        } elseif ($time == $yesterdayTime) {
            $result = '昨天';
        } else {
            $result = date("$str", $time);
        }

        if ($tmpTime == $result) {
            $result = '';
        } else {
            $tmpTime = $result;
        }

        return $result;
    }

    public static function formatTime($dateTime, $str = 'm-d'){
        $time = strtotime($dateTime);
        $way = time() - $time;
        if($way < 60){
            $r = '刚刚';
        }elseif($way >= 60 && $way <3600){
            $r = floor($way/60).'分钟前';
        }elseif($way >=3600 && $way <86400){
            $r = floor($way/3600).'小时前';
        }elseif($way >=86400 && $way <2592000){
            $r = floor($way/86400).'天前';
        }elseif($way >=2592000 && $way <15552000){
            $r = floor($way/2592000).'个月前';
        }else{
            $r = date("$str",$time);
        }
        return $r;
    }
}