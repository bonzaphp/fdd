<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 11:43
 */

namespace bonza\fdd;

use bonza\fdd\interfaces\FddInterface;

class Fdd
{

    private $fdd = null;

    public function __construct(FddInterface $fdd)
    {
        $this->fdd = $fdd;
    }

    public function __call($name, $arguments)
    {
        return $this->fdd->$name(...$arguments);
    }


}