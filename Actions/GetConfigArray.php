<?php

namespace ModulesGarden\PlanetHoster\Actions;

class GetConfigArray extends AbstractAction
{

    /**
     * @return array
     */
    public function execute()
    {
        return [
            'FriendlyName' => [
                'Type' => 'System',
                'Value' => 'PlanetHoster',
            ],
            'APIUser' => [
                'FriendlyName' => 'API User',
                'Type' => 'text',
                'Size' => '100',
                'Default' => '',
                'Description' => ''
            ],
            'APIKey' => [
                'FriendlyName' => 'API Key',
                'Type' => 'password',
                'Size' => '100',
                'Default' => '',
                'Description' => ''
            ]
        ];
    }
}