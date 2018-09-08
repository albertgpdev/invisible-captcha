<?php

namespace Albertgpdev\InvisibleCaptcha;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

class InvisibleCaptcha {
	protected const API_URI = 'https://www.google.com/recaptcha/api.js';
    protected const VERIFY_URI = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Defines the reCaptcha public key.
     * @var String
     */
    protected $publicKey;
    
    /**
     * Defines the reCaptcha private key.
     * @var String
     */
    protected $privateKey;

    /**
     * Creates the invisible reCaptcha
     * @param String $publicKey  "public key provided by Google"
     * @param String $privateKey "private key provided by Google"
     */
    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey; 
        $this->setClient(
            new Client()
        );
    }

    /**
     * Generate rendered view of invisible reCaptcha with the language defined"
     * @param  String $language "Defines the language"
     * @return View           "Return rendered view of reCaptcha"
     */
    public function getCaptcha($language = 'en', $badge="inline")
    {
    	$url = static::API_URI . '?hl=' . $language . '&onload=onLoadCaptcha';


        return view('albertgpdev-invisiblecaptcha::captcha')->with(['url' => $url, 'badge' => $badge])->render();
    }

    /**
     * Verify invisible reCaptcha response.
     * @param String $response
     * @param String $clientIp
     * @return bool
     */
    public function verifyResponse($response, $clientIp)
    {
        if (empty($response)) {
            return false;
        }
        $response = $this->sendVerifyRequest([
            'secret' => $this->privateKey,
            'remoteip' => $clientIp,
            'response' => $response
        ]);
        return isset($response['success']) && $response['success'] === true;
    }

    /**
     * Verify invisible reCaptcha response
     * @param  Request $request "Symfony Request"
     * @return bool
     */
    public function verifyRequest(Request $request)
    {
        return $this->verifyResponse(
            $request->get('g-recaptcha-response'),
            $request->getClientIp()
        );
    }

    /**
     * Send verify request.
     * @param array $query "Array with form params"
     * @return array
     */
    protected function sendVerifyRequest(array $query = [])
    {   
        $response = $this->client->post(static::VERIFY_URI, [
            'form_params' => $query,
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Getter function of publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }


    /**
     * Getter function of PrivateKey
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }
    
    /**
     * Getter function of GuzzleClient
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Setter for publicKey
     *
     * @param String $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * Setter for Private
     *
     * @param String $privateKey
     */
    public function setPrivateKey($publicKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * Setter for GuzzleClient
     *
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}


