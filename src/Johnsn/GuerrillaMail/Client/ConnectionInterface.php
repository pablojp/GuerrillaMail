<?php
/**
 * Created by PhpStorm.
 * User: nicholasjohns
 * Date: 12/21/13
 * Time: 11:24 PM
 */

namespace Johnsn\GuerrillaMail\Client;

interface ConnectionInterface
{
    public function retrieve($action, array $query);
    public function transmit($action, array $query);
}
