<?php

namespace MVC
{
    include_once 'Loader.php';
    class App
    {
        private static $_instance = null;
        private $_config = null;

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