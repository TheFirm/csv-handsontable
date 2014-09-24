<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @var $app Silex\Application
 */

$app->match('/php_sdk/oauth.php', function (Request $request) use ($app) {
    $api = Helpers\Auth::authorize($app['conf']);

    if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
        header('Location: ' . $api->getAuthorizeUri());
        exit;
    }

    return $app->redirect('/');
}, 'GET');


$app->match('/', function (Request $request) use ($app) {
    $api = Helpers\Auth::authorize($app['conf']);

    return $app['twig']->render('index.html', array(
        'avatar' => Helpers\General::getAva($api),
    ));
}, 'GET');


$app->match('/uploadfile', function (Request $request) use ($app) {
    Helpers\Auth::authorize($app['conf']);
    if ($app['request']->isMethod('POST')) {
        $MAX_FILE_SIZE = 1000000; //10Mb
        $TYPE_FILES = ['text/csv', "application/vnd.ms-excel"];

        if (isset($_FILES['file'])) {
            if ($_FILES['file']['size'] >= $MAX_FILE_SIZE) {
                return $app->json(array('success' => 'false', 'error' => 'File to large!'));
            }
            if (!in_array($_FILES['file']['type'], $TYPE_FILES)) {
                return $app->json(array('success' => 'false', 'error' => 'File format not supported!'));
            }
            $path = $_FILES['file']['tmp_name'];
            $csvFileReader = new \Helpers\CSVFileReader($path);

            return $app->json($csvFileReader->print_result());
        } else {
            $jsonString = file_get_contents('php://input');
            if ($jsonString) {
                $csvFileReader = new \Helpers\CSVFileReader($jsonString, false);
                return $app->json($csvFileReader->print_result());
            }
        }
    }

    return $app->json(array('error' => 'Error!'));
}, 'POST');


$app->match('/supportedColumns', function (Request $request) use ($app) {
    Helpers\Auth::authorize($app['conf']);
    return $app->json(array('SupportedColumns' => $app['conf']['SupportedColumns']));
}, 'GET');


$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return false;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});