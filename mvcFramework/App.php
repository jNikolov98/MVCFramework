<?php

namespace MVC
{
    include_once 'Loader.php';
    class App
    {
        private static $_instance = null;

        private function __construct()
        {
            \MVC\Loader::registerNamespace('MVC', dirname(__FILE__).DIRECTORY_SEPARATOR);
            \MVC\Loader::registerAutoLoad();
        }

        public function run()
        {

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