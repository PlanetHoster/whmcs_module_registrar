<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;
use WHMCS\Results\ResultsList;
use WHMCS\Domain\TopLevel\ImportItem;

class GetTldPricing extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->TldPricing();

        if (isset($response->error)) {
            return ['error' => $response->error];
        }

        if (!isset($response->extensionData)) {
            return ['error' => 'cannot sync domain at this time'];
        }
        $extensionData = $response->extensionData;
        $results = new ResultsList;
        foreach ($extensionData as $extension) {
            $item = (new ImportItem)
                ->setExtension($extension->tld)
                ->setMinYears($extension->minPeriod)
                ->setMaxYears($extension->maxPeriod)
                ->setRegisterPrice($extension->registrationPrice)
                ->setRenewPrice($extension->renewalPrice)
                ->setTransferPrice($extension->transferPrice)
                ->setCurrency($extension->currencyCode)
                ->setEppRequired($extension->transferSecretRequired);
            $results[] = $item;
        }
        return $results;
    }
}
