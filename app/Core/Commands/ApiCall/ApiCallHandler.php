<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Jamal
 * Date: 12/4/17
 * Time: 11:27 PM
 */

namespace App\Core\Commands\ApiCall;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class ApiCallHandler
{
    public $endPoint;
    public $header = [];
    public $body;
    public $requestMethod = 'get';


    function __construct(array $jsonBody = [], $appendToSubUrl = null)
    {
        $this->header = ['headers' => $this->handelHeader()];
        $this->body = ['json' => $jsonBody];

        if ($appendToSubUrl) {
            $this->subUrl .= $appendToSubUrl;
        }
    }

    private function handelHeader()
    {
        array_push($this->header, ['accept' => 'application/json']);
    }

    public function request()
    {
        try {
            $client = new Client();
            $request = $client->request($this->requestMethod, $this->endPoint, $this->options());
            if ($request->getStatusCode() >= 200 && $request->getStatusCode() < 300) {
                $data = json_decode($request->getBody()->getContents());
                $data = json_decode(json_encode($data), True);
                return ['data' => $data, 'code' => $request->getStatusCode()];
            }
            return ['data' => ['error', $request->getBody()->getContents()], 'code' => $request->getStatusCode()];
        } catch (ClientException $exception) {

            return [
                'data' => ["error" => $exception->getResponse()],
                'code' => $exception->getCode()
            ];
        }

    }

    private function options()
    {
        return array_merge(
            $this->header,
            $this->body,
            ['http_errors' => false]
        );
    }
}