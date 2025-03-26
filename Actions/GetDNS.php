<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class GetDNS extends AbstractAction
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

        $response = $planethoster->RetrieveDNSZone($this->params['sld'] . "." . $this->params['tld'], $worldId);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        $allowedRecords = [
            'A',
            'AAAA',
            'MXE',
            'MX',
            'CNAME',
            'TXT'
        ];

        $records = [];

        foreach($response->data as $record)
        {
            if(!in_array($record->type, $allowedRecords))
            {
                continue;
            }

            $address = '';
            $priority = '';

            switch($record->type)
            {
                case 'A':
                case 'AAAA':
                    $address = $record->records[0]->ip;
                    break;
                case 'MX':
                case 'MXE':
                    $address = $record->records[0]->value;
                    $priority = $record->records[0]->priority;
                    break;
                case 'CNAME':
                    $address = $record->records[0]->value;
                    break;
                case 'TXT':
                    $address = $record->records[0]->content;
                    break;
            }

            $records[] = [
                'hostname' => $record->name,
                'type' => $record->type,
                'address' => $address,
                'priority' => $priority
            ];
        }

        return $records;
    }
}