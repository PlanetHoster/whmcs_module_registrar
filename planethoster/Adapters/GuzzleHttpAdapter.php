<?php

namespace ModulesGarden\PlanetHoster\Adapters;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use ModulesGarden\PlanetHoster\Middleware\Logging;

class GuzzleHttpAdapter
{
    const DEFAULT_ENDPOINT = 'https://api.planethoster.net';

    protected $client;

    protected $response;

    /**
     * @param $api_user
     * @param $api_key
     * @param $api_sandbox
     * @param $timeout
     * @param $base_url
     * @param ClientInterface|null $client
     */
    public function __construct($api_user, $api_key, $api_sandbox = '0', $timeout = 120, $base_url = self::DEFAULT_ENDPOINT, ClientInterface $client = null)
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);
        $stack->push(new Logging());

        $this->client = $client ?: new Client([
            'headers' => [
                'X-API-USER' => $api_user,
                'X-API-KEY' => $api_key,
                'X-API-SANDBOX' => $api_sandbox,
                'Content-Type' => 'application/json',
            ],
            'timeout' => $timeout,
            'base_uri' => $base_url,
            'handler' => $stack
        ]);
    }

    /**
     * @param $uri
     * @param $content
     * @return string
     */
    public function get($uri, $content = '')
    {
        return $this->request('GET', $uri, $content);
    }

    /**
     * @param $uri
     * @param $content
     * @return string
     */
    public function delete($uri, $content = '')
    {
        return $this->request('DELETE', $uri, $content);
    }

    /**
     * @param $uri
     * @param $content
     * @return string
     */
    public function put($uri, $content = '')
    {
        return $this->request('PUT', $uri, $content);
    }

    /**
     * @param $uri
     * @param $content
     * @return string
     */
    public function post($uri, $content = '')
    {
        return $this->request('POST', $uri, $content);
    }

    /**
     * @param $uri
     * @param $content
     * @return string
     */
    public function patch($uri, $content = [])
    {
        return $this->request('PATCH', $uri, $content);
    }

    /**
     * @param $method
     * @param $uri
     * @param $options
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($method, $uri, $options = '')
    {
        try
        {
            $this->response = $this->client->request($method, $uri, [
                'body' => json_encode($options)
            ]);
        }
        catch (RequestException $e)
        {
            $this->response = $e->getResponse();

            if(is_null($this->response))
            {
                throw $e;
            }

            $this->handleError();
        }

        return (string) $this->response->getBody();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function handleError()
    {
        $body = (string) $this->response->getBody();
        $content = json_decode($body);
        $code = isset($content->error_code) ? $content->error_code : ((int) $this->response->getStatusCode());
        throw new Exception(isset($content->error) ? $content->error : 'Request not processed', $code);
    }
}