<?php

namespace Models;

class TOC
{
    private $_apiKey = null;
    private $_url = null;
    private $_sessionId = null;

    /**
     * TOC constructor.
     */
    public function __construct()
    {
        $this->_apiKey = $_ENV['API_KEY'];
        $this->_url = $_ENV['TOC_URL'];
    }


    /**
     * @return null
     */
    public function getSessionId()
    {
        return $this->_sessionId;
    }


    /**
     * @return mixed
     */
    public function generateSessionId()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->_url/session-manager/v1/session-id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"apiKey\":\"$this->_apiKey\",\"liveness\":true,\"autocapture\":true, \"fake_detector\": true}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $decodedResponse = json_decode($response);
        $this->_sessionId = $decodedResponse->session_id;
        return $this->_sessionId;

    }

    /**
     * Comparamos contra la API de Face and Document para que nos retorne el resultado de la validación
     * @param string $id_front
     * @param string $id_back
     * @param string $selfie
     * @param string $documentType
     */
    public function checkResult($id_front, $id_back, $selfie, $documentType = "CHL2")
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->_url/v2/face-and-document",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'id_front' => $id_front,
                'id_back' => $id_back,
                'selfie' => $selfie,
                'documentType' => $documentType,
                'apiKey' => $this->_apiKey,
                "liveness_passive" => true
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}