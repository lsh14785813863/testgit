<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\facade\Env;
use think\facade\Request;

define("OAPI_HOST", "https://oapi.dingtalk.com");
//开发者后台->应用开发-企业内部应用->选择您创建的小程序->应用首页-查看详情->查看AppKey
define("APP_KEY", "dingpwnnry9cuxuyethm");
//开发者后台->应用开发-企业内部应用->选择您创建的小程序->应用首页-查看详情->查看AppSecret
define("APP_SECRET", "7pIYNk2ICAvVJH02LrY6eMiC3-fpEWVaMahGdgXd-NhzUhzYLEYhuOP191Imwuft");


/**
 * 返回状态码、信息、数据
 * @param int $code
 * @param string $msg
 * @param array $data
 * @param int $count
 * @return string
 */
function jsonData(int $code = 0, string $msg = 'ok', $data = [], $count = 0)
{
    if (Request::isAjax())
    {
        exit(json_encode(['code'=>$code,'msg'=>$msg,'count'=>$count,'data'=>$data]));
    }
    else
    {
        exit($msg);
    }
}

function getAccessToken($appKey = APP_KEY,$appSecret = APP_SECRET) {
    $fileName = Env::get('APP_PATH').'common/token.txt';
    $token = json_decode(file_get_contents($fileName),true);
    //halt($token);
    $access_token = $token['access_token'];
    $time = time();
    if ( $time > $token['expires_in'])
    {
        $url = "https://oapi.dingtalk.com/gettoken?appkey=$appKey&appsecret=$appSecret";
        $ret = getUrl($url);
        if ($ret['errcode'] !== 0) {
            return ('获取access_token错误，'.$ret->errmsg);
        }
        $access_token = $ret['access_token'];
        $data = [
            'gain_time' => $time,
            'access_token' => $access_token,
            'expires_in' => $time + $ret['expires_in']
        ];
        file_put_contents($fileName, json_encode($data), LOCK_EX);
    }
    return $access_token;
}

function getUrl($url){
    $headerArray =array("Content-type:application/json;","Accept:application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output,true);
    return $output;
}
function postUrl($url,$data){
    $data  = json_encode($data);
    $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return json_decode($output,true);
}
function putUrl($url,$data){
    $data = json_encode($data);
    $ch = curl_init(); //初始化CURL句柄
    curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output,true);
}
function delUrl($url,$data){
    $data  = json_encode($data);
    $ch = curl_init();
    curl_setopt ($ch,CURLOPT_URL,$url);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output,true);
    return $output;
}
function patchUrl($url,$data){
    $data  = json_encode($data);
    $ch = curl_init();
    curl_setopt ($ch,CURLOPT_URL,$url);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);     //20170611修改接口，用/id的方式传递，直接写在url中了
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);
    return $output;
}