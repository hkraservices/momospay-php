<?php

namespace Mpay;

/**
 * Created by vscode
 * User: itss
 * Date: 2022-28-10
 * Time: 02:23
 */

class Mpay
{
    /**
     * key for payment
     */
    private static $secret_key;

    /**
     * environement sandbox
     */
    private static $environement;

    public static function setApiKey(string $secret_key)
    {
        Mpay::$secret_key = $secret_key ?? null;
    }

    public static function getApiKey()
    {
        return Mpay::$secret_key;
    }

    public static function setEnvironment(string $environement)
    {
        Mpay::$environement = $environement ?? null;
    }

    public static function getEnvironment()
    {
        return   Mpay::$environement;
    }
}
