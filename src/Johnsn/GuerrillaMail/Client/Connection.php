<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nick
 * Date: 8/8/13
 * Time: 5:36 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Johnsn\GuerrillaMail\Client;

/**
 * Class Connection
 * @package Johnsn\GuerrillaMail\Client
 */
abstract class Connection implements ConnectionInterface
{
    /**
     * GuerrillaMail api endpoint.
     * @var string
     */
    protected $url = 'http://api.guerrillamail.com/ajax.php';

    /**
     * Client IP Address
     * @var string
     */
    protected $ip = "127.0.0.1";

    /**
     * Client Agent
     * @var string
     */
    protected $agent = "GuerrillaMail_Library";

    /**
     * Format query string for GuerrillaMail API consumption.
     *
     * @param $action
     * @param array $options
     * @return string
     */
    public function build_query($action, array $options)
    {
        $query = "f={$action}";
        foreach($options as $key => $value) {
            if(!is_array($value)) {
                $query .= "&{$key}=" . urlencode($value);
                continue;
            }

            foreach($value as $a_key => $a_value) {
                $query .= "&{$key}%5B%5D=" . urlencode($a_value);
            }
        }

        return $query;
    }

    protected function buildResponseObject($code, $data)
    {
        $response = array('status' => $code, 'data' => $data);
        if($code >= 300) {
            $response['status'] = false;
        }

        return $response;
    }

    /**
     * HTTP GET
     *
     * @param string $action
     * @param array $query
     * @return mixed
     */
    abstract function retrieve($action, array $query);

    /**
     * HTTP POST
     *
     * @param string $action
     * @param array $query
     * @return mixed
     */
    abstract function transmit($action, array $query);
}
