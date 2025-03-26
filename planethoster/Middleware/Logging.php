<?php

namespace ModulesGarden\PlanetHoster\Middleware;

use Closure;

class Logging
{

    /**
     * @param $handler
     * @return Closure
     */
    public function __invoke($handler)
    {
        return function ($request, $options) use ($handler) {
            return $handler($request, $options)->then(function ($response) use ($request) {
                $this->log($request, $response);
                return $response;
            });
        };
    }

    /**
     * @param $request
     * @param $response
     * @return void
     */
    protected function log($request, $response)
    {
        $action = $request->getRequestTarget();
        $requestAsString = $this->getRequestAsString($request);
        $responseAsString = $response instanceof \Exception ? $response->getMessage() : $this->getResponseAsString($response);

        \logModuleCall('PlanetHoster', $action, $requestAsString, $responseAsString, $responseAsString);
    }

    /**
     * @param $request
     * @return string
     */
    protected function getRequestAsString($request)
    {
        $requestAsString = $request->getMethod() . " " . $request->getRequestTarget() . ' HTTP/' . $request->getProtocolVersion() . "\r\n";

        foreach($request->getHeaders() as $name => $value)
        {
            $requestAsString .= $name . ': ' . $value[0] . "\r\n";
        }

        $requestAsString .= "\r\n";
        $requestAsString .= $request->getBody();

        return $requestAsString;
    }

    /**
     * @param $response
     * @return string
     */
    protected function getResponseAsString($response)
    {
        $responseAsString = "HTTP/" . $response->getProtocolVersion() . " " . $response->getStatusCode() . " " . $response->getReasonPhrase() . "\r\n";

        foreach($response->getHeaders() as $name => $value)
        {
            $responseAsString .= $name . ': ' . $value[0] . "\r\n";
        }

        $responseAsString .= "\r\n";
        $responseAsString .= $response->getBody();

        return $responseAsString;
    }
}