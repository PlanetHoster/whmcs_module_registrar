<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class SaveRegistrarLock extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        if($this->params['lockenabled'] == "locked")
        {
            $response = $planethoster->ActivateRegistrarLock($this->params['sld'], $this->params['tld']);
        }
        else
        {
            $response = $planethoster->DeactivateRegistrarLock($this->params['sld'], $this->params['tld']);
        }

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => 'success'
        ];
    }
}