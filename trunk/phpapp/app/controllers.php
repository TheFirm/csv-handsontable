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

function authorize($conf){

    $api = new Humanity\Api($conf['humanity-sdk']);

    // This is changed to match our endpoints
    $api->setAuthorizeEndpoint('https://master-accounts.dev.humanity.com/oauth2/authorize');
    $api->setTokenEndpoint('https://master-accounts.dev.humanity.com/oauth2/token');
    $api->setApiEndpoint('https://master-api.dev.humanity.com/v1/');

    if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
    // No valid access token available, go to authorization server
        header('Location: ' . $api->getAuthorizeUri());
        exit;
    }

    return $api;
}

$app->match('/php_sdk/oauth.php', function (Request $request) use ($app) {
    if ($api = authorize($app['conf'])) {
        if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
            header('Location: ' . $api->getAuthorizeUri());
            exit;
        }
        return $app->redirect('/');
    }
}, 'GET');

$app->match('/', function (Request $request) use ($app) {

    if ($api = authorize($app['conf'])) {
        $api->setAuthorizeEndpoint('https://master-accounts.dev.humanity.com/oauth2/authorize');
        $api->setTokenEndpoint('https://master-accounts.dev.humanity.com/oauth2/token');
        $api->setApiEndpoint('https://master-api.dev.humanity.com/v1/');
        $credentials = $api->get('oauth/credentials');
        $employees =$api->get("companies/{$credentials['company_id']}/employees");
        $lexer = new Twig_Lexer($app['twig'], array(
            'tag_variable'  => array('[[', ']]'),
        ));
        $app['twig']->setLexer($lexer);
        if($employees){
            $ava = str_replace('[size]','300x300',$employees[0]['avatar']?$employees[0]['avatar']['path']:'/img/default_avatar_300x300.png');
        }

        return $app['twig']->render('index.html', array(
            'avatar' => $ava,
            'account_avatar' => $employees[0]['account_avatar'],
            'display_name' => $employees[0]['display_name'],
        ));
    }
    return $app->json(array('error'=>'Error!'));
}, 'GET');


$app->match('/uploadfile', function (Request $request) use ($app) {

    if ($api = authorize($app['conf'])) {
    $request = $app['request'];
        if ($request->isMethod('POST')) {
            $MAX_FILE_SIZE = 1000000;
            $TYPE_FILES = ['text/csv', "application/vnd.ms-excel"];

            if (isset($_FILES['file'])) {
                if ($_FILES['file']['size'] >= $MAX_FILE_SIZE) {
                    echo json_encode(array('success' => 'false', 'error' => 'File to large!'));
                    exit;
                }
                if (!in_array($_FILES['file']['type'], $TYPE_FILES)) {
                    echo json_encode(array('success' => 'false', 'error' => 'File format not supported!'));
                    exit;
                }
                $path = $_FILES['file']['tmp_name'];
                $csvFileReader = new \Helpers\CSVFileReader($path);
                return $app->json($csvFileReader->print_result());
            }else{
                $json = file_get_contents('php://input');
                if($json){
                    $csvFileReader = new \Helpers\CSVFileReader($json, false);
                    return $app->json($csvFileReader->print_result());
                }
            }
        }
    }
    return $app->json(array('error'=>'Error!'));
}, 'POST');

$app->match('/supportedColumns', function (Request $request) use ($app) {
    if ($api = authorize($app['conf'])) {
        return $app->json(array('SupportedColumns'=>$app['conf']['SupportedColumns']));
    }
}, 'GET');


$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
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