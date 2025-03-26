<?php

namespace ModulesGarden\PlanetHoster\Actions;

use Exception;
use ModulesGarden\PlanetHoster\Adapters\GuzzleHttpAdapter;
use ModulesGarden\PlanetHoster\API\PlanetHoster;

class GetContactDetails extends AbstractAction
{
    /**
     * @return array
     * @throws Exception
     */
    public function execute()
    {
        $adapter = new GuzzleHttpAdapter($this->params['APIUser'], $this->params['APIKey']);
        $planethoster = new PlanetHoster($adapter);

        $response = $planethoster->ContactsDetails($this->params['sld'], $this->params['tld']);

        if(isset($response->error))
        {
            throw new Exception($response->error);
        }

        return [
            'Registrant' => $this->getDomainContact($response->contacts, 'registrant')
        ];
    }

    /**
     * @param $contacts
     * @param $type
     * @return array
     */
    protected function getDomainContact($contacts, $type)
    {
        $contactArray = [
            'First Name' => "",
            'Last Name' => "",
            'Company Name' => "",
            'Email' => "",
            'Address 1' => "",
            'Address 2' => "",
            'City' => "",
            'State' => "",
            'Postcode' => "",
            'Country' => "",
            'Phone Number' => "",
        ];

        foreach($contacts as $contact)
        {
            if($contact->contact_type == $type)
            {
                $contactArray['First Name'] = explode(" ", $contact->name)[0];
                $contactArray['Last Name'] = explode(" ", $contact->name)[1];
                $contactArray['Company Name'] = $contact->company_name;
                $contactArray['Email'] = $contact->email;
                $contactArray['Address 1'] = $contact->addr->address1;
                $contactArray['Address 2'] = $contact->addr->address2;
                $contactArray['City'] = $contact->addr->city;
                $contactArray['State'] = $contact->addr->state;
                $contactArray['Postcode'] = $contact->addr->postal_code;
                $contactArray['Country'] = $contact->addr->country;
                $contactArray['Phone Number'] = $contact->phone_number;

                break;
            }
        }

        return $contactArray;
    }
}