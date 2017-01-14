<?php
namespace MVC;
class Validation
{
    private $_rules = array();
    private $_errors = array();

    public function setRule($rule, $value, $params = null, $name = null)
    {
        $this->_rules[] = array('val' => $value, 'rule' => $rule, 'par' => $params, 'name' => $name);
        return $this;
    }

    public function validate()
    {
        $this->_errors = array();
        if(count($this->_rules) > 0)
        {
            foreach ($this->_rules as $rule) {
                if(!$this->$rule['rule']($rule['val'], $rule['par']))
                {
                    if($rule['name'])
                    {
                        $this->_errors[] = $rule['name'];
                    } else {
                        $this->_errors[] = $rule['rule'];
                    }
                }
            }
        }
        return (bool) !count($this->_errors);

    }

    public static function custom($val1, $val2)
    {
        if($val2 instanceof \Closure)
        {
            return (boolean) call_user_func($val2, $val1);
        }
        throw new \Exception('Invalid validation function', 500);
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function __call($name, $arguments)
    {
        throw new \Exception('Invalid validation rule', 500);
    }

    public static function matches($val1, $val2)
    {
        return $val1 == $val2;
    }

    public static function minlength($val1, $val2)
    {
        return (mb_strlen($val1) >= $val2);
    }


    /*
     * TODO:: get other methods for validation from code (lek 37, 13:00)
     */
}