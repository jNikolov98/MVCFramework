<?php

namespace MVC;


class Common
{
    public static function normalize($data, $types)
    {
        $types = explode('|', $types);
        if (is_array($types)) {
            foreach ($types as $type) {
                if ($type == 'int') {
                    $data = (int)$data;
                }
                if ($type == 'float') {
                    $data = (float)$data;
                }
                if ($type == 'double') {
                    $data = (double)$data;
                }
                if ($type == 'bool') {
                    $data = (bool)$data;
                }
                if ($type == 'string') {
                    $data = (string)$data;
                }
                if ($type == 'trim') {
                    $data = trim($data);
                }
                if ($type == 'xss') {
                    $data = self::xss_clean($data);
                }
            }
        }
        return $data;
    }

    /*
    * thx to:  https://gist.github.com/mbijon/1098477
    * @param   string  $input  Content to be cleaned. It MAY be modified in output
    * @return  string  $input  Modified $input string
    */
    public static function xss_clean($input)
    {
        // Fix &entity\n;
        $input = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $input);
        $input = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $input);
        $input = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $input);
        $input = html_entity_decode($input, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $input = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+[>\b]?#iu', '$1>', $input);
        // Remove javascript: and vbscript: protocols
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $input);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $input);
        return $input;
    }

    public static function headerStatus($code)
    {
        $codes = array(
            100 => 'Continue',
            101 => 'Switch Protocols',
        );
        if(!$codes[$code])
        {
            $code = 500;
        }
        header($_SERVER['SERVER_PROTOCOL'].' '. $statusCode . ' '. $codes[$code], true, $code);
    }
}