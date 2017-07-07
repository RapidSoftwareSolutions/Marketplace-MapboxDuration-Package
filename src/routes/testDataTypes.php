<?php

$app->post('/api/MapboxDuration/testDataTypes', function ($request, $response, $args) {
    /** @var \Slim\Http\Response $response */
    /** @var \Slim\Http\Request $request */
    /** @var \Models\checkRequest $checkRequest */

    $settings = $this->settings;
    $checkRequest = $this->validation;

    $data = $request->getBody();


    $result = json_decode($request->getBody()->getContents(), true);
    if (empty($result) || json_last_error()) {
        $result = $request->getParsedBody();
    }

    $client = $this->httpClient;
    $resp = $client->post("http://e77bf52c.ngrok.io", ["json"=>$result]);

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    $validateRes = $checkRequest->validate($request, ['accessToken']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        $client = $this->httpClient;
        $resp = $client->post("http://e77bf52c.ngrok.io");
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }
//    var_dump($postData['args']);
//    die();
    $url = $settings['apiUrl'] . '/driving';

    $params['access_token'] = $postData['args']['accessToken'];
    $result = $postData['args'];

});