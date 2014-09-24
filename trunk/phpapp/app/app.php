<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;

/**
 * @var $app Silex\Application
 */

$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(__DIR__ . '/views'),
    'twig.options' => array('cache' => __DIR__ . '/../cache/twig'),
));

$app['twig']->setLexer(
    new Twig_Lexer(
        $app['twig'], array(
            'tag_variable' => array('[[', ']]'),
        )
    )
);

$app['conf'] = Helpers\General::loadConfig();
$app['debug'] = $app['conf']['debug'];

return $app;