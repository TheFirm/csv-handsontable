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

$app->match('/php-sdk/oauth.php', function (Request $request) use ($app) {
    getHumanityApiClient($app)->authorize();

    return $app->redirect('/');
}, 'GET');


$app->match('/', function (Request $request) use ($app) {
    $api = getHumanityApiClient($app)->authorize();

    return $app['twig']->render('index.html', array(
        'avatar' => false//Helpers\General::getAva($api),
    ));
}, 'GET');


$app->match('/upload', function (Request $request) use ($app) {
    if ($app['request']->isMethod('POST')) {
        getHumanityApiClient($app)->authorize();
        $MAX_FILE_SIZE = 1000000; //10Mb

        $config_name = $request->query->get('e', 'employee');

        if (isset($_FILES['file'])) {
            if ($_FILES['file']['size'] >= $MAX_FILE_SIZE) {
                return $app->json(array('error' => true, 'text' => 'File to large. Max 10Mb.'));
            }
            if (!in_array($_FILES['file']['type'], $app['conf']['allowedMimeTypes'])) {
                return $app->json(array('error' => true, 'text' => sprintf('File format not supported. Only CSV files allowed. Your file MIME-type is "%s"', $_FILES['file']['type'])));
            }

            $file_info = pathinfo($_FILES['file']['name']);
            if($file_info["extension"] !== 'csv'){
                return $app->json(array('error' => true, 'text' => 'Only CSV files supported.'));
            }

            $filePath = $_FILES['file']['tmp_name'];
            $csvFileReader = new \Helpers\CSVFileReader($filePath);

            $headers = $csvFileReader->getHeaders();
            $rows = $csvFileReader->getRows();
        } else {
            $jsonString = file_get_contents('php://input');
            $requestData = json_decode($jsonString, true);

            if(!isset($requestData['rows'])){
                throw new \Exception('Missing rows', 400);
            }

            if(!isset($requestData['headers'])){
                throw new \Exception('Missing headers', 400);
            }

            $headers = \Helpers\Transformer::transformColsIn($requestData['headers']);
            $rows = \Helpers\Transformer::transformRowsIn($requestData['rows']);
        }

        $validator = new \Helpers\Validator($rows, $headers);
        $result = $validator->validateColumns($config_name);
        if($result['success']){

        }

        $result['data'] = [
            'headers' => \Helpers\Transformer::transformColsOut($headers),
            'rows' => \Helpers\Transformer::transformRowsOut($rows),
        ];

        return $app->json($result);
    }

    return $app->json(array('error' => 'Error!'));
}, 'POST');

$app->match('/supportedColumns', function (Request $request) use ($app) {
    getHumanityApiClient($app)->authorize();

    $entity = $request->query->get('e', 'employee');

    $conf = \Helpers\General::readValidatorConfig();

    if(!array_key_exists($entity, $conf)){
        throw new \Exception('Missing entity', 400);
    }

    $selectedConf = $conf[$entity];

    foreach ($selectedConf as $confName => $confVal) {
        $newKey = \Helpers\General::transformConfigHeaderName($confName);
        $conf[$newKey] = $confVal;
        unset($conf[$confName]);
    }

    return $app->json(array('SupportedColumns' => $conf));
}, 'GET');


$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'Not found.';
            break;
        default:
            $message = $e->getMessage();
    }

    $response = [
        'success' => false,
        'message' => $message
    ];

    return new JsonResponse($response, $code);
});

/**
 * @param \Silex\Application $app
 * @return \Helpers\HumanityApiClient
 */
function getHumanityApiClient(Silex\Application $app) {
  return $app['humanityApiClient'];
}