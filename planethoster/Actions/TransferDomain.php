<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class TransferDomain extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->TransferDomain($this->params['sld'], $this->params['tld'], $this->params['eppcode']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => true
        ];
    }
}