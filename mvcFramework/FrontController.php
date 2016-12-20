<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 21.12.2016 г.
 * Time: 00:23 ч.
 */

namespace MVC;


class FrontController
{
private static $_instance = null;
    private function __construct()
    {
    }

    public function dispatch()
    {

    }

    /**
     * @return FrontController|null
     */
    public static function getInstance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new \MVC\FrontController();
        }
        return self::$_instance;
    }
}