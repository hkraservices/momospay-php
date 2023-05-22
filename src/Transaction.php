<?php

namespace Momospay;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\json_encode;


class Transaction
{

    /**
     * @var Momospay
     */

    /**
     * @var Constants
     */

    /**
     * @var STATUS
     */

    /**
     * key for payment
     */
    private $secret_key;

    /**
     * environement sandbox
     */
    private $environement;

    /**
     * Guzzcle client
     */
    private $curl;

    /**
     * paymentType
     */
    private $paymentType;

    /**
     * showCloseBtn
     */
    private $showClose;

    public function __construct()
    {
        $this->curl = new GuzzleHttp\Client();
        $this->secret_key     = Momospay::getApiKey();
        $this->environement   = Momospay::getEnvironment();
    }

    public static function get_self()
    {
        return new self();
    }

    public static function get_static()
    {
        return new static();
    }


    public static function create(array $dataPayment)
    {
        $const = self::get_self()->environement == 'live' ? Constants::LIVE_URL : Constants::SANDBOX_URL;
        $response = null;

        if ($dataPayment ?? false) {
            try {
                $response = self::get_self()->curl->post($const . 'api/v1/transactions/getTokensSecretKey', [
                    "json" => [
                        'infoPayment' => \json_encode([
                            'transaction' => $dataPayment['transaction'],
                            'customer' => $dataPayment['customer'],
                            'custom_metadata' =>  $dataPayment['custom_metadata'],
                            'return_url' => $dataPayment['return_url']
                        ]),
                        'site_domains' => $dataPayment['site_domains'],
                        'methodepayment' => $dataPayment['methodepayment'],
                        'secret_key' => self::get_self()->secret_key,
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-SECRET-KEY' => self::get_self()->secret_key
                    ]
                ]);

                $response = \json_decode($response->getBody()->getContents());

                if ($response->success) {
                    return \json_decode(\json_encode(['url' => $response->data->url]));
                }
            } catch (RequestException $e) {
                // If there are network errors, we need to ensure the application doesn't crash.
                // if $e->hasResponse is not null we can attempt to get the message
                // Otherwise, we'll just pass a network unavailable message.

                if ($e->hasResponse()) {
                    return \json_encode(array("status" => STATUS::FAILED));
                } else {
                    return  \json_decode($e->getMessage(), 503);
                }
            }
        } else {
            return 'Validation Error , No request';
        }
    }

    public static function retrieve(int $transactionId)
    {
        $response = null;
        try {
            $const = self::get_self()->environement == 'live' ? Constants::LIVE_URL : Constants::SANDBOX_URL;

            $responses = self::get_self()->curl->post($const  . 'api/v1/transactions/status', array(
                "json" => array("transactionId" => $transactionId),
                'headers' => [
                    'Accept' => 'application/json',
                    'X-SECRET-KEY' => self::get_self()->secret_key
                ]
            ));
            $response = \json_decode($responses->getBody()->getContents());

            if ($response->success) {
                return \json_decode(\json_encode($response->data));
            }

            return \json_encode(array("status" => STATUS::TRANSACTION_NOT_FOUND));
        } catch (\Exception $e) {
            return \json_encode(array("status" => STATUS::TRANSACTION_NOT_FOUND));
        }
    }
}
