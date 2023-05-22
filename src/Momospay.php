<?php

namespace Momospay;

/**
 * Created by vscode
 * User: itss
 * Date: 2022-28-10
 * Time: 02:23
 */

class Momospay
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
        Momospay::$secret_key = $secret_key ?? null;
    }

    public static function getApiKey()
    {
        return Momospay::$secret_key;
    }

    public static function setEnvironment(string $environement)
    {
        Momospay::$environement = $environement ?? null;
    }

    public static function getEnvironment()
    {
        return   Momospay::$environement;
    }
}
