<?php

ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../app/app.php';

require __DIR__.'/../app/controllers.php';

$app->run();