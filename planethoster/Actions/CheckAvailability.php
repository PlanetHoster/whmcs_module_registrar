<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;
use WHMCS\Domains\DomainLookup\SearchResult;
use WHMCS\Domains\DomainLookup\ResultsList;

class CheckAvailability extends AbstractAction
{

    /**
     * @return ResultsList
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $results = new ResultsList();

        foreach($this->params['tldsToInclude'] as $tld)
        {
            $response = $planethoster->CheckDomainAvailability($this->params['searchTerm'], ltrim($tld, '.'));

            if(isset($response->error))
            {
                throw new Exception($response->error);
            }

            $searchResult = new SearchResult($this->params['searchTerm'], ltrim($tld, '.'));
            $searchResult->setStatus($response->available ? SearchResult::STATUS_NOT_REGISTERED : SearchResult::STATUS_REGISTERED);

            if($response->is_premium)
            {
                $searchResult->setPremiumDomain(true);
                $searchResult->setPremiumCostPricing([
                    'register' => $response->premium_register_price,
                    'renew' => $response->premium_renew_price,
                    'CurrencyCode' => 'USD'
                ]);
            }

            $results->append($searchResult);
        }

        return $results;
    }
}