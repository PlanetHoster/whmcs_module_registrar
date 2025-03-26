<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class GetNameservers extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->GetNameservers($this->params['sld'], $this->params['tld']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'ns1' => $response->nameservers[0] ?? "",
            'ns2' => $response->nameservers[1] ?? "",
            'ns3' => $response->nameservers[2] ?? "",
            'ns4' => $response->nameservers[3] ?? "",
            'ns5' => $response->nameservers[4] ?? "",
        ];
    }
}