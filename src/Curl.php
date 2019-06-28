<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-28
 * Time: 09:24
 */

namespace bonza\fdd;


class Curl
{
    /**
     * 发送post请求
     * @param string $url 请求路由
     * @param string $method 请求方式post/get
     * @param string $data 传入参数
     * @return \stdClass $temp 返回数组参数
     */
    public function sendRequest($url, $method = 'post', $data = ''):\stdClass
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
        $temp = json_decode($temp);
        curl_close($ch);
        return $temp; //return 返回值
    }
}