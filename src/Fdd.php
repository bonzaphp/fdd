<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 11:43
 */

namespace bonza\fdd;

use bonza\fdd\api\FddApi3;

class Fdd
{

    private $fdd = null;

    public function __construct($options)
    {
        $this->fdd = new FddApi3($options);
    }

    /**
     * 代理接口请求到具体的实例
     * @param $name
     * @param $arguments
     * @return mixed
     * @author bonzaphp@gmail.com
     */
    public function __call($name, $arguments)
    {
        return $this->fdd->$name(...$arguments);
    }


}