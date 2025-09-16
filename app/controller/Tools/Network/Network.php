<?php

/**
 * |------------------------
 * |        Network
 * |------------------------
 */

namespace TOOL\Network;

class Network
{

    /**
     * Is online method
     * 
     * @return bool
     */
    static function isOnline()
    {

        $response = null;
        system("ping -c 1 google.com", $response);

        return $response == 0 ? false : true;
    }

    /**
     * Curl method
     * 
     * @param string $url
     * 
     * @param $data
     * 
     * @param ?array $header
     * 
     * @return string
     */
    static function curl(string $url, $data = null, ?array $header = null)
    {


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set header
        if ($header)
            curl_setopt($ch, CURLOPT_HTTPHEADER,  $header);

        // Set data
        if ($data)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        // do anything you want with your response
        return $response;
    }
}
