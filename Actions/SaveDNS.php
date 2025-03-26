<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class SaveDNS extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->TheWorldInformation();

        if(isset($response->error))
        {
            throw new \Exception($response->error);
        }

        $worldId = null;

        foreach($response->world_accounts as $worldAccount)
        {
            if($worldAccount->domain == $this->params['sld'] . "." . $this->params['tld'])
            {
                $worldId = $worldAccount->id;
                break;
            }
        }

        $records = [];

        foreach($this->params['dnsrecords'] as $record)
        {
            if(empty($record['hostname']) && empty($record['address']))
            {
                continue;
            }

            $records[] = [
                'type' => $record['type'],
                'name' => $record['hostname'],
                'value' => $record['address'],
                'priority' => $record['priority'],
            ];
        }

        $response = $planethoster->ModifyDNSZone($this->params['sld'] . "." . $this->params['tld'], $records, $worldId);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => 'success'
        ];
    }
}