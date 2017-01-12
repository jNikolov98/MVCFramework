<?php

namespace MVC
{
    include_once 'Loader.php';
    class App
    {
        private static $_instance = null;
        private $_config = null;
        private $router = null;
        private $_dbConnections = array();
        private $_frontController = null;
        private $_session = null;

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

            $_sess = $this->_config->app['session'];
            if($_sess['autostart'])
            {
                if($_sess['type'] == 'native')
                {
                    $_s = new \MVC\Sessions\NativeSession($_sess['name'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
                } else if(($_sess['type'] == 'database'))
                {
                    $_s = new \MVC\Sessions\DBSession($_sess['dbConnection'], $_sess['name'], $_sess['dbTable'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
                } else
                {
                    throw new \Exception('No valid session', 500);
                }
                $this->setSession($_s);
            }

            $this->_frontController->dispatch();
        }

        public function setSession(\MVC\Sessions\ISession $session)
        {
            $this->_session = $session;
        }

        public function getSession()
        {
            return $this->_session;
        }

        public function getDBConnection($connection = 'default')
        {
            if(!$connection)
            {
                throw new \Exception('No connection identifier provided', 500);
            }
            if($this->_dbConnections[$connection])
            {
                return $this->_dbConnections[$connection];
            }
            $_cnf = $this->getConfig()->database;
            if(!$_cnf[$connection]){
                throw new \Exception('No valid connection identificator is provided', 500);
            }
            $dbh = new \PDO($_cnf[$connection]['connection_uri'], $_cnf[$connection]['username'], $_cnf[$connection]['password'], $_cnf[$connection]['pdo_options']);
            $this->_dbConnections[$connection] = $dbh;
            return $dbh;
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

        public function __destruct()
        {
            if($this->_session != null)
            {
                $this->_session->saveSession();
            }
        }
    }
}