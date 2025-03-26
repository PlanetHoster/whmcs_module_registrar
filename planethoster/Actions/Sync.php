<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class Sync extends AbstractAction
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

        return [
            'expirydate' => $response->expiry_date,
            'active' => $response->registration_status == "Active",
            'transferredAway' => (bool) $response->is_transfer
        ];
    }
}