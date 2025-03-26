<?php

namespace ModulesGarden\PlanetHoster\API;

class PlanetHoster
{
    protected $adapter;

    /**
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return mixed
     */
    public function Hello()
    {
        $content = $this->adapter->get('/v3/hello');

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function DomainInformation($sld, $tld)
    {
        $content = $this->adapter->get('/v3/domain', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @param $regperiod
     * @param $nameservers
     * @param $contact
     * @return mixed
     */
    public function RegisterDomain($sld, $tld, $regperiod, $nameservers, $contact, $idProtection, $additionalFields = [])
    {
        $params = [
            'sld' => $sld,
            'tld' => $tld,
            'period' => $regperiod,
            'registrant_first_name' => $contact['first_name'],
            'registrant_last_name' => $contact['last_name'],
            'registrant_email' => $contact['email'],
            'registrant_company_name' => $contact['company_name'],
            'registrant_address1' => $contact['address1'],
            'registrant_address2' => $contact['address2'],
            'registrant_city' => $contact['city'],
            'registrant_postal_code' => $contact['postal_code'],
            'registrant_state' => $contact['state'],
            'registrant_country_code' => $contact['country_code'],
            'registrant_phone' => $contact['phone'],
            'id_protection' => $idProtection,
            'register_if_premium' => true,
            'use_planethoster_nameservers' => false,
            'addtl_field' => $additionalFields
        ];

        for($i = 0; $i < sizeof($nameservers); $i++)
        {
            $params[sprintf("ns%d", $i + 1)] = $nameservers[$i];
        }

        $content = $this->adapter->post('/v3/domain/register', $params);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @param $period
     * @return mixed
     */
    public function RenewDomain($sld, $tld, $period)
    {
        $content = $this->adapter->post('/v3/domain/renew', [
            'sld' => $sld,
            'tld' => $tld,
            'period' => $period
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @param $epp
     * @return mixed
     */
    public function TransferDomain($sld, $tld, $epp)
    {
        $content = $this->adapter->post('/v3/domain/transfer', [
            'sld' => $sld,
            'tld' => $tld,
            'epp_code' => $epp
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function ContactsDetails($sld, $tld)
    {
        $content = $this->adapter->get('/v3/domain/contacts', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @param $contact
     * @return mixed
     */
    public function UpdateContactDetails($sld, $tld, $contact)
    {
        $content = $this->adapter->patch('/v3/domain/contacts', [
            'sld' => $sld,
            'tld' => $tld,
            'registrant_first_name' => $contact['first_name'],
            'registrant_last_name' => $contact['last_name'],
            'registrant_email' => $contact['email'],
            'registrant_company_name' => $contact['company_name'],
            'registrant_address1' => $contact['address1'],
            'registrant_address2' => $contact['address2'],
            'registrant_city' => $contact['city'],
            'registrant_postal_code' => $contact['postal_code'],
            'registrant_state' => $contact['state'],
            'registrant_country_code' => $contact['country_code'],
            'registrant_phone' => $contact['phone'],
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function RegistrarLock($sld, $tld)
    {
        $content = $this->adapter->get('/v3/domain/lock', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function ActivateRegistrarLock($sld, $tld)
    {
        $content = $this->adapter->put('/v3/domain/lock', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function DeactivateRegistrarLock($sld, $tld)
    {
        $content = $this->adapter->delete('/v3/domain/lock', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function GetNameservers($sld, $tld)
    {
        $content = $this->adapter->get('/v3/domain/nameservers', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @param $nameservers
     * @return mixed
     */
    public function UpdateNameservers($sld, $tld, $nameservers)
    {
        $params = [
            'sld' => $sld,
            'tld' => $tld,
        ];

        for($i = 0; $i < sizeof($nameservers); $i++)
        {
            $params[sprintf("ns%d", $i + 1)] = $nameservers[$i];
        }

        $content = $this->adapter->put('/v3/domain/nameservers', $params);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function EmailEPPCode($sld, $tld)
    {
        $content = $this->adapter->post('/v3/domain/auth-info', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @param $domain
     * @param $worldId
     * @return mixed
     */
    public function RetrieveDNSZone($domain, $worldId = null)
    {
        $request = [
            'domain' => $domain,
        ];

        if($worldId)
        {
            $request['id'] = $worldId;
        }

        $content = $this->adapter->get('/v3/hosting/domain/dns-zone', $request);

        return json_decode($content);
    }

    /**
     * @param $domain
     * @param $records
     * @param $worldId
     * @return mixed
     */
    public function ModifyDNSZone($domain, $records, $worldId)
    {
        $rrsets = [];

        foreach($records as $record)
        {
            $value = [];

            switch($record['type'])
            {
                case 'A':
                case 'AAAA':
                    $value['ip'] = $record['value'];
                    break;
                case 'MX':
                case 'MXE':
                    $value['value'] = $record['value'];
                    $value['priority'] = $record['priority'];
                    break;
                case 'CNAME':
                    $value['value'] = $record['value'];
                    break;
                case 'TXT':
                    $value['content'] = $record['value'];
                    break;
            }

            $rrsets[] = [
                'type' => $record['type'],
                'name' => $record['name'],
                'ttl' => 14400,
                'records' => [
                    $value
                ]
            ];
        }

        $request = [
            'domain' => $domain,
            'rrsets' => $rrsets
        ];

        if($worldId)
        {
            $request['id'] = $worldId;
        }

        $content = $this->adapter->patch('/v3/hosting/domain/dns-zone', $request);

        return json_decode($content);
    }

    /**
     * @param $sld
     * @param $tld
     * @return mixed
     */
    public function CheckDomainAvailability($sld, $tld)
    {
        $content = $this->adapter->get('/v3/domain/availability', [
            'sld' => $sld,
            'tld' => $tld
        ]);

        return json_decode($content);
    }

    /**
     * @return mixed
     */
    public function TheWorldInformation()
    {
        $content = $this->adapter->get('/v3/the-world/info');

        return json_decode($content);
    }
}