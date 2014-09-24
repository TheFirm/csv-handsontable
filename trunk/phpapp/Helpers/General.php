<?php

namespace Helpers;


class General {

    public static function loadConfig(){
        $conf_file_path = dirname(__FILE__) . '/../config/conf.php';

        if(!file_exists($conf_file_path)){
            die("Missing conf file. Please copy it from conf.php.sample");
        }
        return require($conf_file_path);
    }
} 