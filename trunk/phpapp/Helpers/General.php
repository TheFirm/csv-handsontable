<?php

namespace Helpers;


use Humanity\Api;

class General {

    /**
     * Returns config array or display missing config error
     * @return string[] config array
     */
    public static function loadConfig(){
        $conf_file_path = dirname(__FILE__) . '/../config/conf.php';

        if(!file_exists($conf_file_path)){
            die("Missing conf file. Please copy it from conf.php.sample");
        }
        return require($conf_file_path);
    }

    /**
     * Returns user ava from API
     * @param \Humanity\Api $api
     * @return string ava path
     */
    public static function getAva(Api $api){
        $credentials = $api->get('oauth/credentials');
        $employees = $api->get("companies/{$credentials['company_id']}/employees");

        $ava = '/img/default_avatar_300x300.png';

        if($employees and count($employees) > 0 and isset($employees[0]['avatar'])){
            $ava = str_replace('[size]', '300x300', $employees[0]['avatar']['path']);
        }

        return $ava;
    }
} 