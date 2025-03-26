<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class SaveNameservers extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->UpdateNameservers($this->params['sld'], $this->params['tld'], $this->getNameservers());

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => true
        ];
    }

    /**
     * @return array
     */
    protected function getNameservers()
    {
        return [
            $this->params['ns1'],
            $this->params['ns2'],
            $this->params['ns3'],
            $this->params['ns4'],
            $this->params['ns5']
        ];
    }
}