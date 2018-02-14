<?php


class Config {
    private static $config;

    public static function get($key) {
        if (!self::$config) {

            /**
             * if APPLICATION_ENV constant exists (set in Apache configs) else 'development'
             */
            $enviroment =  (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development');
            $config_file = './application/config/config.' . $enviroment . '.php';

            if (!file_exists($config_file)) {
                return false;
            }

            self::$config = require $config_file;            
        }

        return self::$config[$key];
    }
}


