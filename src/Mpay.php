<?php

namespace Mpay;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\json_encode;
use Mpay\helpers;


/**
 * Created by vscode
 * User: webcoom
 * Date: 2022-28-10
 * Time: 02:23
 * THIS FILE CONTAINS ALL MPAY API STATUS
 */

class Mpay
{
    /**
     * public key for payment
     */
    private $public_key;

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * Guzzcle client
     */
    private $client;

    /**
     * paymentType
     */
    private $paymentType;

    /**
     * showCloseBtn
     */
    private $showClose;

    /**
     * sandbox
     */
    private $sandbox;


    public function __construct($public_key,  $sandbox = false)
    {

        // $this->client = new \GuzzleHttp\Client(['allow_redirects' => true,]);
        $this->public_key = $public_key;
        $this->sandbox = $sandbox;
        $this->paymentType = 'mobile';
        $this->showClose = false;

        $this->client = new \GuzzleHttp\Client([
            'verify' => __DIR__ . '/../data/cacert.pem'
        ]);
    }

    /**
     * getInfoToken function help to get token of payment information given 
     * @param float $amount            // transaction amount
     * @param string $payment_raison     // transaction raison
     * @param string $email             // email of the person who wants to perform the operation
     * @param string $lastname          // lastname of the person who wants to perform the operation
     * @param string $firstname         // firstname of the person who wants to perform the operation
     * @param string $return_url        // redirect url  after operation
     * @param string $payment_type       // payment  may be 'mobile' or 'card'
     * @param string $site_domain       // domain link
     */
    public function getTokens(float $amount, string $payment_raison, string $email, string $lastname, string $firstname, string $return_url = null, string $payment_type, string $site_domain)
    {
        $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;
        $response = $this->client->request('POST', $const . 'api/v1/getTokens', [
            'form_params' => [
                'infoPayment' => \json_encode([
                    'transaction' => [
                        'amount' => $amount,
                        'description' =>
                        'Paiement pour' . $payment_raison,
                    ],
                    'customer' => [
                        'email' => $email,
                        'lastname' =>  $lastname,
                        'firstname' =>  $firstname
                    ],
                    'return_url' => $return_url
                ]), 'site_domains' => $site_domain,
                'public_key' =>  $this->public_key,
                'methodepayment' => $payment_type,
            ]
        ]);

        $response = \json_decode($response->getBody()->getContents());
        if ($response->success) {
            $data = $response->data;
            $url = Constants::FRONT_BASE_URL . '=' . $this->paymentType . '&cloosebtn=' . $this->boolToStr($this->showClose) . '&token=' . $data->token;
        }
        return  \json_decode(\json_encode(['url' => $url]));
    }


    function boolToStr($value)
    {
        return $value ? 'true' : 'false';
    }


    // public function hash($str)
    // {
    //     if ($this->getSecret() == null) throw new \Exception("Secret key is not set");
    //     return urlencode(base64_encode(hash_hmac('SHA256', $str, $this->getSecret(), TRUE)));
    // }

    // public function verifyTransaction($transactionId)
    // {
    //     $response = null;
    //     try {

    //         $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;

    //         $response = $this->client->post($const . '/api/v1/transactions/status', array(
    //             "json" => array("transactionId" => $transactionId),
    //             'headers' => [
    //                 'Accept' => 'application/json',
    //                 'X-API-KEY' => $this->public_key,
    //                 'X-PRIVATE-KEY' => $this->private_key,
    //                 'X-SECRET-KEY' => $this->secret
    //             ]
    //         ));

    //         $response = $response->getBody()->getContents();
    //     } catch (RequestException $e) {

    //         $body = ($e->getResponse()->getBody());

    //         $errors = (json_decode((string)$body));

    //         $errors->statusCode = $e->getResponse()->getStatusCode();

    //         return $errors;
    //     }
    //     return json_decode((string)$response);
    // }


    // public function refundTransaction($transactionId)
    // {
    //     $reponse = null;
    //     try {

    //         $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;

    //         $response = $this->client->post($const . '/api/v1/transactions/revert', array(

    //             "json" => array("transactionId" => $transactionId),
    //             'headers' => [
    //                 'Accept'     => 'application/json',
    //                 'X-API-KEY'      => $this->public_key
    //             ]
    //         ));

    //         $reponse = $response->getBody();
    //         return json_decode((string)$reponse);
    //     } catch (RequestException $e) {
    //         if ($e->hasResponse()) {
    //             $reponse = "{" . $this->get_string_between(Psr7\str($e->getResponse()), "{", "}") . "}";

    //             return json_decode((string)$reponse);
    //         }
    //         $reponse = json_encode(array("status" => STATUS::FAILED));
    //         return json_decode((string)$response);
    //     }
    // }




    // public function setupPayout(array $options)
    // {
    //     $reponse = null;
    //     try {

    //         $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;

    //         $response = $this->client->post($const . '/merchant/payouts/schedule', array(
    //             "json" => $options,
    //             'headers' => [
    //                 'Accept'     => 'application/json',
    //                 'X-API-KEY'      => $this->public_key,
    //                 'X-PRIVATE-API-KEY'      => $this->private_key,
    //                 'X-SECRET-API-KEY'      => $this->secret,
    //             ]
    //         ));

    //         $reponse = $response->getBody();
    //         return json_decode((string)$reponse);
    //     } catch (RequestException $e) {
    //         if ($e->hasResponse()) {
    //             $reponse = "{" . $this->get_string_between(Psr7\str($e->getResponse()), "{", "}") . "}";
    //             return json_decode((string)$reponse);
    //         }
    //         $reponse = json_encode(array("status" => STATUS::FAILED));
    //         return json_decode((string)$response);
    //     }
    // }


    // function get_string_between($string, $start, $end)
    // {
    //     $string = ' ' . $string;
    //     $ini = strpos($string, $start);
    //     if ($ini == 0) return '';
    //     $ini += strlen($start);
    //     $len = strpos($string, $end, $ini) - $ini;
    //     return substr($string, $ini, $len);
    // }
}
