<?php

namespace MVC
{
    include_once 'Loader.php';
    class App
    {
        private static $_instance = null;
        private $_config = null;
        private $router = null;

        private $_frontController = null;

        private function __construct()
        {
            \MVC\Loader::registerNamespace('MVC', dirname(__FILE__).DIRECTORY_SEPARATOR);
            \MVC\Loader::registerAutoLoad();
            $this->_config = \MVC\Config::getInstance();
            if($this->_config->getConfigFolder() == null)
            {
                $this->setConfigFolder('../config');
            }
        }

        public function setConfigFolder($path)
        {
            $this->_config->setConfigFolder($path);
        }

        public function getConfigFolder()
        {
            return $this->_config->getConfigFolder();
        }


        public function getRouter()
        {
            return $this->router;
        }


        public function setRouter($router)
        {
            $this->router = $router;
        }

        /**
         * @return Config|null
         */
        public function getConfig()
        {
            return $this->_config;
        }

        public function run()
        {
            if ($this->_config->getConfigFolder() == null)
            {
                $this->setConfigFolder('../config');
            }
            $this->_frontController = \MVC\FrontController::getInstance();
            if ($this->router instanceof \MVC\Routers\IRouter)
            {
                $this->_frontController->setRouter($this->router);
            }else if($this->router == 'JsonRPCRouter'){
                /**
                 * TODO:: fix it when RPC is done
                 */
                $this->_frontController->setRouter(new \MVC\Routers\DefaultRouter());
            } else if($this->router == 'CLIRouter'){
                /**
                 * TODO:: fix it when CLI is done
                 */
                $this->_frontController->setRouter(new \MVC\Routers\DefaultRouter());
            } else {
                $this->_frontController->setRouter(new \MVC\Routers\DefaultRouter());
            }

            $this->_frontController->dispatch();
        }

        /**
         * @return \MVC\App
         */
        public static function getInstance()
        {
            if(self::$_instance == null)
            {
                self::$_instance = new \MVC\App();
            }
            return self::$_instance;
        }
    }
}