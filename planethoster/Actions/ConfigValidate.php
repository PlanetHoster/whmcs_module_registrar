<?php

namespace ModulesGarden\PlanetHoster\Actions;

use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapterWithLogging;
use ModulesGarden\PlanetHoster\API\PlanetHoster;
use WHMCS\Exception\Module\InvalidConfiguration;

class ConfigValidate extends AbstractAction
{

    /**
     * @return array
     * @throws InvalidConfiguration
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $info = $planethoster->Hello();

        if(isset($info->error))
        {
            throw new InvalidConfiguration('API Error: ' . $info->error);
        }

        return [
            'success' => true
        ];
    }
}