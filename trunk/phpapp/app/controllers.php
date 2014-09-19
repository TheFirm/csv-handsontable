<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\StreamedResponse;

function authorize(){
    $api = new Humanity\Api(array(
        'client_id' => '95982517764489216',
        'client_secret' => null,
        'redirect_uri' => 'http://www.humanity.dev/php_sdk/oauth.php',
    ));

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

$app->match('/', function (Request $request) use ($app) {

    if ($api = authorize()) {
        return file_get_contents(__DIR__.'/views/index.html', FILE_USE_INCLUDE_PATH);
    }
    return $app->json(array('error'=>'Error!'));
}, 'GET');

$app->match('/uploadfile', function (Request $request) use ($app) {

    if ($api = authorize()) {
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
                $csvFileReader->print_result();
                return $app->json($csvFileReader->print_result());
            }else{
                $json = file_get_contents('php://input');
                if($json){
                    var_dump($json);
                    $obj = json_decode($json);
                    var_dump($obj);
                }
            }
        }
    }
    return $app->json(array('error'=>'Error!'));
}, 'GET|POST');

$app->match('/user', function (Request $request) use ($app) {

    if ($api = authorize()) {
        $credentials = $api->get('oauth/credentials');
//        var_dump($credentials);
        $employees = $api->get("companies/{$credentials['company_id']}/employees");
//        var_dump($employees);
        return $app->json(array('employees'=>$employees));
    }
    return $app->json(array('error'=>'Error!'));
}, 'GET|POST');

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