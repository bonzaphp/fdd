<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 11:43
 */

namespace bonza\fdd;

use bonza\fdd\Encrypt;


class Fdd
{
    use FddApi2;
    /**
     * @var string
     */
    private $appId;
    /**
     * @var string
     */
    private $appSecret;
    /**
     * @var string
     */
    private $timestamp;
    /**
     * @var string api版本
     */
    private $version = '2.0';
    /**
     * @var string
     */
    private $baseUrl = 'https://testapi.fadada.com:8443/api/';


    /**
     * @var Curl
     */
    private $curl = null;


    /**
     * 法大大统一调用入口
     * @param Curl $curl
     * @param array $options =[
     *      'appId' =>'', 接入ID
     *      'appSecret'=>'',接入密钥
     *      'baseUrl'=>'',接口地址
     * ]
     */
    public function __construct(Curl $curl,$options = [])
    {
        $this->timestamp = date("YmdHis");
        $this->appId = $options['appId'];
        $this->appSecret = $options['appSecret'];
        $this->baseUrl = $options['baseUrl']??$this->baseUrl;
        $this->curl = $curl;

    }

    /**
     * 设置接口基础地址
     * @param string $baseUrl
     * @return Fdd
     */
    public function setBaseUrl(string $baseUrl): Fdd
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }


}

