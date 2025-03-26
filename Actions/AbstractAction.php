<?php

namespace ModulesGarden\PlanetHoster\Actions;

use WHMCS\Domains\DomainLookup\ResultsList;

abstract class AbstractAction
{
    /**
     * @var array common module parameters
     */
    protected $params;

    /**
     * @param array $params common module parameters
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @return array|string|ResultsList
     */
    public abstract function execute();
}