<?php

$app->post('/api/MapboxDuration/getCyclingDurationByFile', function ($request, $response, $args) {
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

    $params['access_token'] = $postData['args']['accessToken'];

    $toJson = new \Models\normilizeJson();
    $data = $toJson->normalizeJson(file_get_contents($postData['args']['coordinates']));
    $data = str_replace('\"', '"', $data);
    $fileContent['coordinates'] = json_decode($data, true);

    try {
        /** @var GuzzleHttp\Client $client */
        $client = $this->httpClient;
        $vendorResponse = $client->post($url, [
            'json' => $fileContent,
            'query' => $params
        ]);
        $vendorResponseBody = $vendorResponse->getBody()->getContents();
        $rawBody = json_decode($vendorResponse->getBody());
        $error = $rawBody->responses[0]->error;
        $all_data[] = $rawBody;
        if ($vendorResponse->getStatusCode() == '200' && !isset($error)) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($all_data) ? $all_data : json_decode($all_data);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($vendorResponseBody) ? $vendorResponseBody : json_decode($vendorResponseBody);
        }
    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        $vendorResponseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($vendorResponseBody);
    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});