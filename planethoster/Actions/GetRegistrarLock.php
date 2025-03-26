<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class GetRegistrarLock extends AbstractAction
{

    /**
     * @return string
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->RegistrarLock($this->params['sld'], $this->params['tld']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return $response->is_locked ? 'locked' : 'unlocked';
    }
}