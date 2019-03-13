<?php
/**
 * Function for getting configuration data from configuration file
 */
if(!function_exists('config')) {
    function config($key, $file = 'app')
    {
        $array = include BASE_PATH . '/config/' . $file . '.php';
        $path = explode('.', $key); //if needed
        $temp = &$array;
        foreach ($path as $keyx) {
            $temp =& $temp[$keyx];
        }
        return (($temp) === NULL || is_array($temp)) ? $file . '.error.' . $key : $temp;
    }
}