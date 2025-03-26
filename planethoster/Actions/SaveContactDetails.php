<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class SaveContactDetails extends AbstractAction
{

    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $registrant = $this->getDomainContact('Registrant');

        $response = $planethoster->UpdateContactDetails($this->params['sld'], $this->params['tld'], $registrant);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'success' => true
        ];
    }

    /**
     * @param $type
     * @return array
     */
    protected function getDomainContact($type)
    {
        $contactDetails = $this->params['contactdetails'][$type];

        $domainContact = [
            'first_name' => $contactDetails['First Name'],
            'last_name' => $contactDetails['Last Name'],
            'email' => $contactDetails['Email'],
            'company_name' => $contactDetails['Company Name'],
            'address1' => $contactDetails['Address 1'],
            'address2' => $contactDetails['Address 2'],
            'city' => $contactDetails['City'],
            'postal_code' => $contactDetails['Postcode'],
            'state' => $contactDetails['State'],
            'country_code' => $contactDetails['Country'],
            'phone' => $contactDetails['Phone Number'],
        ];

        if($this->params['tld'] == "ca")
        {
            $domainContact['state'] = $this->getCAStateCode($contactDetails['State']);
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