<?php

namespace MVC;


class InputData
{
    private static $_instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();

    private function __construct()
    {
        $this->_cookies = $_COOKIE;
    }

    public function setPost($array)
    {
        if(is_array($array)){
            $this->_post = $array;
        }
    }

    public function setGet($array)
    {
        if(is_array($array))
        {
            $this->_get = $array;
        }
    }

    public function hasGet($id)
    {
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name)
    {
        return array_key_exists($name, $this->_post);
    }

    public function hasCookies($name)
    {
        return array_key_exists($name, $this->_cookies);
    }

    public function get($id, $normalize = null, $default = null)
    {
        if($this->hasGet($id)){
            if($normalize != null) {
                return \MVC\Common::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default = null)
    {
        if($this->hasPost($name)){
            if($normalize != null) {
                return \MVC\Common::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }
        return $default;
    }

    public function cookies($name, $normalize = null, $default = null)
    {
        if($this->hasCookies($name)){
            if($normalize != null) {
                return \MVC\Common::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public static function getInstance(){
        if(self::$_instance == null)
        {
            self::$_instance = new \MVC\InputData();
        }
        return self::$_instance;
    }
}