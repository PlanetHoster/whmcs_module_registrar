<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class TransferSync extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->DomainInformation($this->params['sld'], $this->params['tld']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        if(isset($response->transfer_request_status) && $response->transfer_request_status == "Confirmed")
        {
            return [
                'completed' => true,
                'expirydate' => $response->expiry_date
            ];
        }

        if(isset($response->transfer_request_status) && $response->transfer_request_status == "Denied")
        {
            return [
                'failed' => true,
                'reason' => $response->transfer_request_denied_reason
            ];
        }

        return [];
    }
}