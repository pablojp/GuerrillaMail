<?php

namespace Johnsn\GuerrillaMail;

use Johnsn\GuerrillaMail\Client\ConnectionInterface;

class GuerrillaMail
{
    /**
     * @var Client\ConnectionInterface|null
     */
    private $connection = null;

    /**
     * Available domains
     * @var array
     */
    private $domains = array(
        'guerrillamailblock.com',
        'guerrillamail.com',
        'guerrillamail.org',
        'guerrillamail.net',
        'guerrillamail.biz',
        'guerrillamail.de',
        'sharklasers.com',
        'grr.la',
        'spam4.me',
    );

    /**
     * @param $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return ConnectionInterface|null
     */
    public function getConnectionProvider()
    {
        return $this->connection;
    }

    /**
     * @return array
     */
    public function getDomainList()
    {
        return $this->domains;
    }

    /**
     * Fetch new email address or 
     * resume previous state if $this->sid_token != NULL
     *
     * @param string $lang
     * @return mixed
     */
    public function getEmailAddress($sid_token = null, $lang = 'en')
    {
        $action = "get_email_address";
        $options = array(
            'lang' => $lang,
            'sid_token' => $sid_token,
        );

        return $this->connection->retrieve($action, $options);
    }

    /**
     * Fetch up to 20 new emails starting from the oldest email.
     * If $seq is set, return up to 20 new emails starting from $seq
     *
     * @param int $seq mail_id sequence number starting point
     * @return mixed
     */
    public function checkEmail($sid_token, $seq = 0)
    {
        $action = "check_email";
        $options = array(
            'seq' => $seq,
            'sid_token' => $sid_token,
        );

        return $this->connection->retrieve($action, $options);
    }

    /**
     * Fetch up to 20 new emails starting from the oldest email.
     * If $offset is set, skip to the offset value (0 - 19)
     * If $seq is set, return up to 20 new emails starting from $seq
     *
     * @param int $offset number of items to skip (0 - 19)
     * @param int $seq mail_id sequence number starting point
     * @return mixed
     */
    public function getEmailList($sid_token, $offset = 0, $seq = 0)
    {
        $action = "get_email_list";
        $options = array(
            'offset' => $offset,
            'sid_token' => $sid_token
        );

        if(!empty($seq))
        {
            $options['seq'] = $seq;
        }

        return $this->connection->retrieve($action, $options);
    }

    /**
     * Return email based on $email_id
     *
     * @param $email_id mail_id of the requested email
     * @return bool
     */
    public function fetchEmail($sid_token, $email_id)
    {
        $action = "fetch_email";
        $options = array(
            'email_id' => $email_id,
            'sid_token' => $sid_token
        );

        return $this->connection->retrieve($action, $options);
    }

    /**
     * Change users email address
     *
     * @param $email_user
     * @param string $lang
     * @return bool
     */
    public function setEmailAddress($sid_token, $email_user, $lang = 'en')
    {
        $action = "set_email_user";
        $options = array(
            'email_user' => $email_user,
            'lang' => $lang,
            'sid_token' => $sid_token
        );

        return $this->connection->transmit($action, $options);
    }

    /**
     * Forget users email and sid_token
     *
     * @param $email_address
     * @return bool
     */
    public function forgetMe($sid_token, $email_address)
    {
        $action = "forget_me";
        $options = array(
            'email_addr' => $email_address,
            'sid_token' => $sid_token
        );

        return $this->connection->transmit($action, $options);
    }

    /**
     * Delete the emails matching the array of mail_id's in $email_ids
     * @param $email_ids list of mail_ids to delete from the server.
     * @return bool
     */
    public function deleteEmail($sid_token, $email_ids)
    {
        $action = "del_email";
        $options = array(
            'email_ids' => $email_ids,
            'sid_token' => $sid_token
        );

        return $this->connection->transmit($action, $options);
    }
}
