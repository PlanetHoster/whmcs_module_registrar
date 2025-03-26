<?php

namespace ModulesGarden\PlanetHoster\Actions;

class MetaData extends AbstractAction
{

    /**
     * @return array
     */
    public function execute()
    {
        return [
            'DisplayName' => 'PlanetHoster',
            'APIVersion' => '2.0.0',
        ];
    }
}