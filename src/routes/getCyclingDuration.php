<?php

$app->post('/api/MapboxDuration/getCyclingDuration', function ($request, $response) {
    /** @var \Slim\Http\Response $response */
    /** @var \Slim\Http\Request $request */
    /** @var \Models\checkRequest $checkRequest */

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'coordinates']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }
    $url = $settings['apiUrl'] . '/cycling';

    $token = $postData['args']['accessToken'];
    $json = [];

    foreach ($postData['args']['coordinates'] as $key => $coordinate) {
        if (is_array($coordinate)) {
            $coordinateString .= $json['coordinates'][$key][] = $coordinate['lng'] . ',' . $json['coordinates'][$key][] = $coordinate['lat'] . ';';

        } else {
            $coordinateArray = explode(',', str_replace(" ", "", $coordinate));
            $coordinateString .= $json['coordinates'][$key][] = $coordinateArray[0] . ',' . $json['coordinates'][$key][] = $coordinateArray[1] = $coordinate['lat'] . ';';
        }
    }
    $coordinates = substr($coordinateString, 0, -1);

    try {
        /** @var GuzzleHttp\Client $client */
        $client = $this->httpClient;
        $vendorResponse = $client->get($url . "/" . $coordinates . "?access_token=" . $token);

        $vendorResponseBody = $vendorResponse->getBody()->getContents();
        if ($vendorResponse->getStatusCode() == 200) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_decode($vendorResponse->getBody());
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($vendorResponseBody) ? $vendorResponseBody : json_decode($vendorResponseBody);
        }
    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        $vendorResponseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = json_decode($vendorResponseBody);
    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
