<?php

$app->post('/api/MapboxDuration/testDataTypes', function ($request, $response, $args) {
    /** @var \Slim\Http\Response $response */
    /** @var \Slim\Http\Request $request */
    /** @var \Models\checkRequest $checkRequest */

    $settings = $this->settings;
    $checkRequest = $this->validation;

    $data = $request->getBody();
//    if ($data == '') {
//        $post_data = $request->getParsedBody();
//    }
//    else {
//        $toJson = new \Models\normilizeJson();
//        $data = $toJson->normalizeJson($data);
//        $data = str_replace('\"', '"', $data);
//        $post_data = json_decode($data, true);
//    }
    $result = json_decode($request->getBody()->getContents(), true);
    if (empty($result) || json_last_error()) {
        $result = $request->getParsedBody();
    }
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    $validateRes = $checkRequest->validate($request, ['accessToken']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }
//    var_dump($postData['args']);
//    die();
    $url = $settings['apiUrl'] . '/driving';

    $params['access_token'] = $postData['args']['accessToken'];
    $result = $postData['args'];

//    try {
//        $json['coordinates'] = array_map(
//            function ($item) {
//                return array_map('floatval', array_values($item));
//            },
//            $postData['args']['coordinates']
//        );
//
//        /** @var GuzzleHttp\Client $client */
//        $client = $this->httpClient;
//        $vendorResponse = $client->post($url, [
//            'query' => $params,
//            'json' => $json
//        ]);
//
//        $vendorResponseBody = $vendorResponse->getBody()->getContents();
//        if ($vendorResponse->getStatusCode() == 200) {
//            $result['callback'] = 'success';
//            $result['contextWrites']['to'] = json_decode($vendorResponse->getBody());
//        } else {
//            $result['callback'] = 'error';
//            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
//            $result['contextWrites']['to']['status_msg'] = is_array($vendorResponseBody) ? $vendorResponseBody : json_decode($vendorResponseBody);
//        }
//    } catch (\GuzzleHttp\Exception\ClientException $exception) {
//        $vendorResponseBody = $exception->getResponse()->getBody();
//        $result['callback'] = 'error';
//        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
//        $result['contextWrites']['to']['status_msg'] = json_decode($vendorResponseBody);
//    }

//    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json')->withJson($result);
});