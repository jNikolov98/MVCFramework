<?php
namespace MVC;

class View
{
    private static $_instance = null;
    private $viewPath = null;
    private $viewDir = null;
    private $data = array();
    private $layoutParts = array();
    private $layoutData = array();
    private $extension = '.php';
    private function __construct()
    {
        $this->viewPath = \MVC\App::getInstance()->getConfig()->app['viewsDirectory'];
        if($this->viewPath == null)
        {
            $this->viewPath = realpath('../views/');
        }

    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if($path)
        {
            $path = realpath($path).DIRECTORY_SEPARATOR;
            if(is_dir($path) && is_readable($path))
            {
                $this->viewDir = $path;
            } else {
                // TODO:: 33 11.33
                throw new \Exception('view path', 500);
            }
        } else {
            // TODO:: 33 11.33
            throw new \Exception('view path', 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if(is_array($data))
        {
            $this->data = array_merge($this->data, $data);
        }

        if(count($this->layoutParts) > 0)
        {
            foreach($this->layoutParts as $k => $v)
            {
                $r = $this->_includeFile($v);
                if($r)
                {
                    $this->layoutData[$k] = $r;
                }
            }
        }

        if($returnAsString)
        {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }
    }

    public function getLayoutData($name)
    {
        return $this->layoutData[$name];
    }

    public function appendToLayout($key, $template)
    {
        if($key && $template)
        {
            $this->layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout require valid key and template', 500);
        }
    }

    private function _includeFile($file)
    {
        if($this->viewDir == null) {
            $this->setViewDirectory($this->viewPath);
        }
        $___fl = $this->viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->extension;
        if(file_exists($___fl) && is_readable($___fl))
        {
            ob_start();
            include $___fl;
            return ob_get_clean();
        } else {
            throw new \Exception('View '. $file. ' cannot be included', 500);
        }

    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public static function getInstance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new \MVC\View();
        }
        return self::$_instance;
    }
}