<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;

/**
 * @var $app Silex\Application
 */

$app['conf'] = Helpers\General::loadConfig();
$app['debug'] = $app['conf']['debug'];

$TwigServiceProviderOptions = [
    'twig.path' => array(__DIR__ . '/views'),
];

if($app['debug']){
    ini_set('display_errors', 1);
} else {
    $TwigServiceProviderOptions['twig.options'] = array('cache' => __DIR__ . '/../cache/twig');
}

$app->register(new TwigServiceProvider(), $TwigServiceProviderOptions);

$app['twig']->setLexer(
    new Twig_Lexer(
        $app['twig'], array(
            'tag_variable' => array('[[', ']]'),
        )
    )
);

$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

return $app;