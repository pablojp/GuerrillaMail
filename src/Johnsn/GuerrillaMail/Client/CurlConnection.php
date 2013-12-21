<?php

namespace Johnsn\GuerrillaMail\Client;

/**
 * Class CurlConnection
 * @package Johnsn\GuerrillaMail\Client
 */
class CurlConnection extends Connection
{
    /**
     * @param string $ip Client IP
     * @param string $agent Client UserAgent
     * @param string $url API Endpoint
     */
    public function __construct($ip, $agent = 'GuerrillaMail_Library', $url = 'http://api.guerrillamail.com/ajax.php')
    {
        $this->ip = $ip;
        $this->agent = $agent;
        $this->url = $url;
    }

    /**
     * HTTP GET using cURL
     *
     * @param string $action
     * @param array $query
     * @return array|mixed
     */
    public function retrieve($action, array $query)
    {
        $url = $this->url . '?'. $this->build_query($action, $query);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(isset($query['sid_token'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $query['sid_token']));
        }

        $output = curl_exec($ch);

        $response = json_decode($output, true);

        $data = $this->buildResponseObject(curl_getinfo($ch, CURLINFO_HTTP_CODE), $response);

        curl_close($ch);
        return $data;
    }

    /**
     * HTTP POST using cURL
     *
     * @param string $action
     * @param array $query
     * @return array|mixed
     */
    public function transmit($action, array $query)
    {
        $url = $this->url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($action, $query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        $response = json_decode($output, true);

        $data = $this->buildResponseObject(curl_getinfo($ch, CURLINFO_HTTP_CODE), $response);

        curl_close($ch);
        return $data;
    }
}
