<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-07-04
 * Time: 10:24
 */

namespace bonza\fdd\tests;

use bonza\fdd\api\FddApi3;
use PHPUnit\Framework\TestCase;
use Mockery;

class FddApi3Test extends TestCase
{
    public function testAccountRegister(...$str)
    {
        $options =[
            'appId' => '402163',
            'appSecret'=>'IXWMOF0WghaoHRqdqD9ZYcxI',
            'baseUrl' => 'https://testapi.fadada.com:8443/api/',
            'version'=>'3.0'
        ];
        $obj = new FddApi3($options);
        $this->assertEquals([],$obj->accountRegister(...$str));
    }
}
