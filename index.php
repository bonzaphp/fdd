<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019/4/29
 * Time: 11:51
 */
namespace bonza\fdd;


use bonza\fdd\api\FddApi3;

require 'vendor/autoload.php';
$options =[
    'appId' => '402163',
    'appSecret'=>'IXWMOF0WghaoHRqdqD9ZYcxI',
    'baseUrl' => 'https://testapi.fadada.com:8443/api/',
    'version'=>'3.0'
];
$fdd = new Fdd(new FddApi3($options));

//$res = $fdd->accountRegister('456');


//$customer_id = $res['data'];
$customer_id = '4233C1588C0EA5E12109E7D90A5DC760';
$result = $fdd->getPersonVerifyUrl($customer_id,'http://fdd.ngrok.bonza.cn/notify.php');
$result['data']['url'] = base64_decode($result['data']['url']);

//$obj =new  \ReflectionClass('bonza\fdd\FddApi2');

//var_dump($obj);die;
//$res  = $obj->getMethods();

echo (json_encode($result));
//echo (json_encode($res));