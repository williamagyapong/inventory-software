<?php
/**
*@author Agyapong William
*@since 01/10/2016
*@package 
*/



class Config
{

    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $loc = explode('/', $path);
         
            foreach ($loc as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
   }

     

}
