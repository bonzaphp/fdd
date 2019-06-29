<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 11:43
 */

namespace bonza\fdd;

//use bonza\fdd\Encrypt;
use bonza\fdd\exception\InvalidArgumentException;

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
    public function __construct(Curl $curl, $options = [])
    {
        $this->timestamp = date("YmdHis");
        if (isset($options['appId'])) {
            $this->appId = $options['appId'];
        } else {
            throw new InvalidArgumentException('参数错误');
        }
        if (isset($options['appSecret'])) {
            $this->appSecret = $options['appSecret'];
        } else {
            throw new InvalidArgumentException('参数错误');
        }
        $this->baseUrl = $options['baseUrl'] ?? $this->baseUrl;
        $this->version = $options['version'] ?? $this->version;
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

    /**
     * 设置版本
     * @param string $version
     * @return Fdd
     */
    public function setVersion(string $version): Fdd
    {
        $this->version = $version;
        return $this;
    }


}

