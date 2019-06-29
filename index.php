<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019/4/29
 * Time: 11:51
 */
namespace bonza\fdd;


require 'vendor/autoload.php';
$options =[
    'appId' => '402163',
    'appSecret'=>'IXWMOF0WghaoHRqdqD9ZYcxI',
    'baseUrl' => 'https://testapi.fadada.com:8443/api/',
    'version'=>'2.0'
];
$fdd = new Fdd((new Curl()),$options);

$res = $fdd->accountRegister('456');

var_dump($res);