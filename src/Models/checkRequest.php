<?php

namespace Models;

use Slim\Http\Request;

require_once('normalizeJson.php');

class checkRequest
{
    public function validate($request, $reqFields = [])
    {
        /** @var Request $request */

        $result = [];
        $json_error = [];
        $error = [];

        $data = $request->getBody();

        if ($data == '') {
            $post_data = $request->getParsedBody();
        } else {
            $toJson = new normilizeJson();
            $data = $toJson->normalizeJson($data);
            $data = str_replace('\"', '"', $data);
            $post_data = json_decode($data, true);
        }

        if (json_last_error() != 0) {
            $json_error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
        }

        if (!empty($json_error)) {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'JSON_VALIDATION';
            $result['contextWrites']['to']['status_msg'] = implode(',', $json_error);
        } else {
            if (!empty($reqFields)) {
                foreach ($reqFields as $item) {
                    if (empty($post_data['args'][$item])) {
                        $error[] = $item;
                    }
                }
            }

            if (!empty($error)) {
                $result['callback'] = 'error';
                $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
                $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
                $result['contextWrites']['to']['fields'] = $error;
            }
        }

        if (empty($result)) {
            $result = $post_data;
        }

        return $result;
    }
}
