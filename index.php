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
    'appSecret'=>'IXWMOF0WghaoHRqdqD9ZYcxI'
];
$fdd = new Fdd((new Curl()),$options);

$res = $fdd->accountRegister('456');

var_dump($res);