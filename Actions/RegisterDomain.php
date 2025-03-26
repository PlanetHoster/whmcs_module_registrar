<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class RegisterDomain extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->RegisterDomain($this->params['sld'], $this->params['tld'], $this->params['regperiod'], $this->getNameservers(), $this->getDomainContact(), (bool) $this->params['idprotection'], $this->params['additionalfields']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => true
        ];
    }

    /**
     * @return array
     */
    protected function getNameservers()
    {
        return [
            $this->params['ns1'],
            $this->params['ns2'],
            $this->params['ns3'],
            $this->params['ns4'],
            $this->params['ns5']
        ];
    }

    /**
     * @return array
     */
    protected function getDomainContact()
    {
        $domainContact = [
            'first_name' => $this->params['adminfirstname'],
            'last_name' => $this->params['adminlastname'],
            'email' => $this->params['adminemail'],
            'company_name' => $this->params['adminemail'],
            'address1' => $this->params['adminaddress1'],
            'address2' => $this->params['adminaddress2'],
            'city' => $this->params['admincity'],
            'postal_code' => $this->params['adminpostcode'],
            'state' => $this->params['adminfullstate'],
            'country_code' => $this->params['admincountry'],
            'phone' => $this->params['adminfullphonenumber'],
        ];

        if($this->params['tld'] == "ca")
        {
            $domainContact['state'] = $this->getCAStateCode($this->params['adminfullstate']);
        }

        return $domainContact;
    }

    protected function getCAStateCode($state)
    {
        $stateCodes = [
            'alberta' => 'AB',
            'british columbia' => 'BC',
            'manitoba' => 'MB',
            'new brunswick' => 'NB',
            'newfoundland and labrador' => 'NL',
            'northwest territories' => 'NT',
            'nova scotia' => 'NS',
            'nunavut' => 'NU',
            'ontario' => 'ON',
            'prince edward island' => 'PE',
            'quebec' => 'QC',
            'saskatchewan' => 'SK',
            'yukon' => 'YT'
        ];

        return  isset($stateCodes[mb_strtolower($state)]) ? $stateCodes[mb_strtolower($state)] : $state;
    }
}