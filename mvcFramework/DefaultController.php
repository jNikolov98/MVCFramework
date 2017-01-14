<?php

namespace MVC;

class DefaultController
{
    /**
     * @var App
     */
    public $app;
    /**
     * @var View|null
     */
    public $view;
    /**
     * @var Config|null
     */
    public $config;
    /**
     * @var InputData|null
     */
    public $input;

    public function __construct()
    {
        $this->app = \MVC\App::getInstance();
        $this->view = \MVC\View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = \MVC\InputData::getInstance();
    }

    public function jsonResponse()
    {

    }
}