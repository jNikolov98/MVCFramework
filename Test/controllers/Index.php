<?php

namespace Controllers;
class Index
{
    public function index()
    {
        $view = \MVC\View::getInstance();
        $view->username = 'jack';
        $view->display('admin.index');
    }
}