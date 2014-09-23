<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;

/**
 * @var $app Silex\Application
 */

$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(__DIR__.'/views'),
    'twig.options' => array('cache' => __DIR__.'/../cache/twig'),
));

$app['debug'] = true;

$app['conf'] = loadConfig();

return $app;


function loadConfig(){
    $conf_file_path = dirname(__FILE__) . '/../config/conf.php';
    var_dump($conf_file_path);
    if(!file_exists($conf_file_path)){
        die("Missing conf file. Please copy it from conf.php.sample");
    }
    return require($conf_file_path);
}