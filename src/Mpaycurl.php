<?php

namespace Mpay;

class Mpay
{

    // Publishable Api key
    private $public_key;

    // Account Private Key
    private $private_key;

    // Account Secret
    private $secret;

    private $curl;

    private $sandbox;

    /**
     * Mpay constructor.
     */
    public function __construct($public_key, $secret = null, $sandbox = false)
    {
        $this->public_key = $public_key;
        $this->secret = $secret;
        $this->sandbox = $sandbox;
        //  $this->curl = new \GuzzleHttp\Client();
    }



    public function verifyTransaction($transactionId)
    {
        try {


            $url = $this->sandbox ? "https://api-sandbox.mpay.me" : "https://api.mpay.me";
            $data = array(
                'transactionId' => $transactionId,
            );
            $headers = [
                'Content-Type' => 'application/json',
                'X-API-KEY' => $this->public_key,
            ];

            // var_dump($headers);

            $data_json = json_encode($data);

            //  var_dump($data_json);

            $ch = curl_init($url . '/api/v1/transactions/status');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER,  array('X-API-KEY:' . $this->public_key, 'Content-Type: application/json'));
            $response  = curl_exec($ch);
            if (curl_errno($ch)) {
                print curl_error($ch);
            }

            curl_close($ch);
            return json_decode((string)$response);
        } catch (\Exception $e) {
            return json_encode(array("status" => "transaction not found"));
        }
    }


    // public function refundTransaction($transactionId){
    //     $reponse = null;
    //   try{

    //     $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;

    //       $response = $this->curl->post($const. '/api/v1/transactions/revert', array(

    //           "json" => array("transactionId" => $transactionId),
    //           'headers' => [
    //               'Accept'     => 'application/json',
    //               'X-API-KEY'      => $this->public_key
    //           ]
    //       ));

    //         $reponse = $response->getBody();
    //         return json_decode((string)$reponse);

    //     }catch (RequestException $e){
    //         if ($e->hasResponse()) {
    //             $reponse = "{".$this->get_string_between(Psr7\str($e->getResponse()), "{","}")."}";

    //             return json_decode((string)$reponse);
    //         }
    //         $reponse = json_encode(array( "status" => STATUS::FAILED));
    //         return json_decode((string)$response);
    //     }
    // }


    // public function setupPayout(array $options){
    //     $reponse = null;
    //   try{

    //       $const = $this->sandbox ? Constants::SANDBOX_URL : Constants::BASE_URL;

    //       $response = $this->curl->post($const. '/merchant/payouts/schedule', array(
    //           "json" => $options,
    //           'headers' => [
    //               'Accept'     => 'application/json',
    //               'X-API-KEY'      => $this->public_key,
    //               'X-PRIVATE-API-KEY'      => $this->private_key,
    //               'X-SECRET-API-KEY'      => $this->secret,
    //           ]
    //       ));

    //         $reponse = $response->getBody();
    //         return json_decode((string)$reponse);

    //     }catch (RequestException $e){
    //         if ($e->hasResponse()) {
    //             $reponse = "{".$this->get_string_between(Psr7\str($e->getResponse()), "{","}")."}";
    //             return json_decode((string)$reponse);
    //         }
    //         $reponse = json_encode(array( "status" => STATUS::FAILED));
    //         return json_decode((string)$response);
    //     }
    // }


    // function get_string_between($string, $start, $end){
    //     $string = ' ' . $string;
    //     $ini = strpos($string, $start);
    //     if ($ini == 0) return '';
    //     $ini += strlen($start);
    //     $len = strpos($string, $end, $ini) - $ini;
    //     return substr($string, $ini, $len);
    // }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->private_key;
    }

    /**
     * @return null
     */
    public function getSecret()
    {
        return $this->secret;
    }
}
