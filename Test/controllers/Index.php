<?php

namespace Controllers;
class Index extends \MVC\DefaultController
{
    public function index()
    {


        $val = new \MVC\Validation();
        $val->setRule('custom', 5,function($a){ echo $a;});
        var_dump($val->validate());

        $view = \MVC\View::getInstance();
        $view->username = 'jack';
        $view->appendToLayout('body', 'admin.index');
        $view->appendToLayout('body2', 'admin.index');
        $view->display('layouts.default2', array('c' =>array(1,2,3,4)), false);
    }
}