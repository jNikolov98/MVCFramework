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
        $a = new \MVC\Routers\DefaultRouter();
        $a->parse();
        $controller = $a->getController();
        $method = $a->getMethod();
        if($controller == null)
        {
            $controller = $this->getDefaultController();
        }
        if($method == null)
        {
            $method = $this->getDefaultMethod();
        }
        echo $controller.'/'.$method;
    }

    public function getDefaultController()
    {
        $controller = \MVC\App::getInstance()->getConfig()->app['default_controller'];
        if($controller)
        {
            return $controller;
        }
        return 'Index';
    }

    public function getDefaultMethod()
    {
        $method = \MVC\App::getInstance()->getConfig()->app['default_method'];
        if($method)
        {
            return $method;
        }
        return 'index';
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