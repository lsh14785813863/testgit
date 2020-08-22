<?php

namespace app\common\ding;

use DingTalkClient;
use DingTalkConstant;
use ResultSet;
use think\facade\Env;
include Env::get('extend_path')."ding\TopSdk.php";
use OapiUserGetRequest;

/**
 * 钉钉SDK请求类
 * Class Request
 * @package app\common\ding
 */
class DRequest
{
    /**
     * @return OapiUserGetRequest
     */
    public static function UserGet(){
        return new OapiUserGetRequest;
    }
    /**
     * 钉钉get请求实例方法
     * @param object $ReqParam
     * @param string $url
     * @return false|mixed|ResultSet
     */
    public static function get($ReqParam, $url)
    {
        // DingTalkConstant::$METHOD_GET 要与下面调用接口url要求的保持一致
        $get = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_GET , DingTalkConstant::$FORMAT_JSON);
        return $get->execute($ReqParam, getAccessToken(),$url);
    }
    /**
     * 钉钉get请求实例方法
     * @param Object $ReqParam
     * @param string $url
     * @return false|mixed|ResultSet
     */
    public function post($ReqParam, $url)
    {
        $post = new DingTalkClient(DingTalkConstant::$CALL_TYPE_OAPI, DingTalkConstant::$METHOD_POST , DingTalkConstant::$FORMAT_JSON);
        return $post->execute($ReqParam, getAccessToken(),$url);
    }
}