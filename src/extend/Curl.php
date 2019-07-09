<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-28
 * Time: 09:24
 */

namespace bonza\fdd\extend;


use bonza\fdd\exception\JsonException;

class Curl
{
    /**
     * 发送post请求
     * @param string $url 请求路由
     * @param string $method 请求方式post/get
     * @param string $data 传入参数
     * @return array $temp 返回数组参数
     */
    public function sendRequest($url, $method = 'post', $data = ''):array
    {
        $ch = curl_init(); //初始化
        $headers = ['Accept-Charset: utf-8'];
        //设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url); //指定请求的URL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method)); //提交方式
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);//二进制流
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //不验证SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //不验证SSL
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //设置HTTP头字段的数组
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 Mozilla/5.0 (compatible;MSIE 5.01;Windows NT 5.0)'); //头的字符串
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); //自动设置header中的Referer:信息
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //提交数值
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //是否输出到屏幕上,true不直接输出
        $temp = curl_exec($ch); //执行并获取结果
        $temp = json_decode($temp,true);
        if (function_exists('json_last_error') && $errMsg = json_last_error()) {
            static::handleJsonError($errMsg);
        } elseif ($temp === null && $data !== 'null') {
            throw new JsonException('Null result with non-null input');
        }
        curl_close($ch);
        return $temp; //return 返回值
    }

    /**
     * 发送请求,返回元首数据
     * @param string $url 请求路由
     * @param string $method 请求方式post/get
     * @param string $data 传入参数
     * @return array $temp 返回数组参数
     */
    public function sendRequestReturnOriginal($url, $method = 'post', $data = ''):array
    {
        $ch = curl_init(); //初始化
        $headers = ['Accept-Charset: utf-8'];
        //设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url); //指定请求的URL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method)); //提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //不验证SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //不验证SSL
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //设置HTTP头字段的数组
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 Mozilla/5.0 (compatible;MSIE 5.01;Windows NT 5.0)'); //头的字符串
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); //自动设置header中的Referer:信息
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //提交数值
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //是否输出到屏幕上,true不直接输出
        $temp = curl_exec($ch); //执行并获取结果
        curl_close($ch);
        return $temp; //return 返回值
    }

    /**
     * 处理json编码过程中可能出现的异常
     * @param $errMsg
     */
    protected static function handleJsonError($errMsg)
    {
        $messages = [
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded', //PHP >= 5.3.3
            JSON_ERROR_NONE => 'Unknown error',
        ];
        throw new JsonException(
            isset($messages[$errMsg])
                ? $messages[$errMsg]
                : 'Unknown JSON error: ' . $errMsg
        );
    }


}