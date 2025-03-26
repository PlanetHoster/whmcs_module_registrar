<?php

if (!defined("WHMCS"))
{
    die("This file cannot be accessed directly");
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . "autoload.php";

use ModulesGarden\PlanetHoster\Actions\TransferSync;
use ModulesGarden\PlanetHoster\Actions\Sync;
use ModulesGarden\PlanetHoster\Actions\CheckAvailability;
use ModulesGarden\PlanetHoster\Actions\SaveDNS;
use ModulesGarden\PlanetHoster\Actions\GetDNS;
use ModulesGarden\PlanetHoster\Actions\SaveRegistrarLock;
use ModulesGarden\PlanetHoster\Actions\GetRegistrarLock;
use ModulesGarden\PlanetHoster\Actions\GetEPPCode;
use ModulesGarden\PlanetHoster\Actions\SaveContactDetails;
use ModulesGarden\PlanetHoster\Actions\GetContactDetails;
use ModulesGarden\PlanetHoster\Actions\SaveNameservers;
use ModulesGarden\PlanetHoster\Actions\GetNameservers;
use ModulesGarden\PlanetHoster\Actions\RenewDomain;
use ModulesGarden\PlanetHoster\Actions\TransferDomain;
use ModulesGarden\PlanetHoster\Actions\RegisterDomain;
use ModulesGarden\PlanetHoster\Actions\ConfigValidate;
use ModulesGarden\PlanetHoster\Actions\GetConfigArray;
use ModulesGarden\PlanetHoster\Actions\MetaData;

/**
 * @return array
 */
function PlanetHoster_MetaData()
{
    $action = new MetaData();
    return $action->execute();
}

/**
 * @return array
 */
function PlanetHoster_getConfigArray()
{
    $action = new GetConfigArray();
    return $action->execute();
}

/**
 * @param array $params
 * @return void
 */
function PlanetHoster_config_validate(array $params)
{
    $action = new ConfigValidate($params);
    $action->execute();
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_RegisterDomain(array $params)
{
    try
    {
        $action = new RegisterDomain($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'RegisterDomain', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_TransferDomain(array $params)
{
    try
    {
        $action = new TransferDomain($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'TransferDomain', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_RenewDomain(array $params)
{
    try
    {
        $action = new RenewDomain($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'RenewDomain', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_GetNameservers(array $params)
{
    try
    {
        $action = new GetNameservers($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'GetNameservers', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_SaveNameservers(array $params)
{
    try
    {
        $action = new SaveNameservers($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'SaveNameservers', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_GetContactDetails(array $params)
{
    try
    {
        $action = new GetContactDetails($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'GetContactDetails', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_SaveContactDetails(array $params)
{
    try
    {
        $action = new SaveContactDetails($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'SaveContactDetails', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_GetEPPCode(array $params)
{
    try
    {
        $action = new GetEppCode($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'GetEPPCode', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return string|array
 */
function PlanetHoster_GetRegistrarLock(array $params)
{
    try
    {
        $action = new GetRegistrarLock($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'GetRegistrarLock', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_SaveRegistrarLock(array $params)
{
    try
    {
        $action = new SaveRegistrarLock($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'SaveRegistrarLock', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_GetDNS(array $params)
{
    try
    {
        $action = new GetDNS($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'GetDNS', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_SaveDNS(array $params)
{
    try
    {
        $action = new SaveDNS($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'SaveDNS', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return \WHMCS\Domains\DomainLookup\ResultsList|array
 */
function PlanetHoster_CheckAvailability(array $params)
{
    try
    {
        $action = new CheckAvailability($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'CheckAvailability', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_Sync(array $params)
{
    try
    {
        $action = new Sync($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'Sync', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}

/**
 * @param array $params common module parameters
 * @return array
 */
function PlanetHoster_TransferSync(array $params)
{
    try
    {
        $action = new TransferSync($params);
        return $action->execute();
    }
    catch(\Exception $e)
    {
        \logModuleCall('PlanetHoster', 'TransferSync', print_r($params, true), $e->getMessage(), $e->getMessage());

        return [
            'error' => $e->getMessage()
        ];
    }
}