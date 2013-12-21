<?php

namespace Johnsn\GuerrillaMail;

class GuerrillaMailTest extends \PHPUnit_Framework_TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = $this->getMockBuilder("Johnsn\\GuerrillaMail\\Client\\ConnectionInterface")
            ->setConstructorArgs(array("127.0.0.1"))
            ->getMock();
    }

    public function tearDown()
    {
        unset($this->connection);
    }

    public function testGetDomainReturnsListOfDomains()
    {
        $domains = array(
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

        $client = new GuerrillaMail($this->connection);

        $result = $client->getDomainList();
        $this->assertEquals($domains, $result);
    }

    public function testGetConnectionReturnsInstanceOfConnectionInterface()
    {
        $client = new GuerrillaMail($this->connection);

        $result = $client->getConnectionProvider();
        $this->assertInstanceOf('\Johnsn\GuerrillaMail\Client\ConnectionInterface', $result);
    }

    public function testGetEmailAddressNotEmpty()
    {
        $response = array(
            'status' => 200,
            'data' => array(
                'msh' => 'making new addre',
                'email_addr' => 'mockemail@guerrillamailblock.com',
                'email_timestamp' => time(),
                'alias' => 'test_alias',
                'sid_token' => '2cvob6bud4l6iqb61tvnklc7i7',
            ),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $gm = new GuerrillaMail($this->connection);

        $email = $gm->getEmailAddress();

        $this->assertEquals($email, $response);
    }

    public function testGetEmailAddressNotEmptyWithSidToken()
    {
        $response = array(
            'status' => 200,
            'data' => array(
                'msh' => 'making new addre',
                'email_addr' => 'mockemail@guerrillamailblock.com',
                'email_timestamp' => time(),
                'alias' => 'test_alias',
                'sid_token' => '2cvob6bud4l6iqb61tvnklc7i7',
            ),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $gm = new GuerrillaMail($this->connection);

        $email = $gm->getEmailAddress('2cvob6bud4l6iqb61tvnklc7i7');

        $this->assertEquals($email, $response);
    }

    public function testCheckEmailReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => array('mock' => 'contents'),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->checkEmail($sid_token);

        $this->assertEquals($response, $result);
    }

    public function testGetEmailListReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => array('mock' => 'contents'),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->getEmailList($sid_token);

        $this->assertEquals($response, $result);
    }

    public function testGetEmailListWithSeqReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => array('mock' => 'contents'),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->getEmailList($sid_token, 0, 20);

        $this->assertEquals($response, $result);
    }

    public function testFetchEmailReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => array('mock' => 'contents'),
        );

        $this->connection->expects($this->once())
            ->method('retrieve')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->fetchEmail($sid_token, 1);

        $this->assertEquals($response, $result);
    }

    public function testSetEmailAddressNotEmptyWithSidToken()
    {
        $response = array(
            'status' => 200,
            'data' => array(
                'd' => 'guerrillamailblock.com',
                'email_addr' => 'different_mockemail@guerrillamailblock.com',
                'email_timestamp' => time(),
                'alias' => 'test_alias',
                'sid_token' => '2cvob6bud4l6iqb61tvnklc7i7',
            ),
        );

        $this->connection->expects($this->once())
            ->method('transmit')
            ->will($this->returnValue($response));

        $gm = new GuerrillaMail($this->connection);

        $email = $gm->setEmailAddress('2cvob6bud4l6iqb61tvnklc7i7', 'different_mockemail@guerrillamailblock.com');

        $this->assertEquals($email, $response);
    }

    public function testForgetMeReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => 1,
        );

        $this->connection->expects($this->once())
            ->method('transmit')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->forgetMe($sid_token, 'mockemail@guerrillamailblock.com');

        $this->assertEquals($response, $result);
    }

    public function testDeleteEmailReturnsResponseArray()
    {
        $sid_token = '2cvob6bud4l6iqb61tvnklc7i7';
        $response = array(
            'status' => 200,
            'data' => array(1, 2, 3),
        );

        $this->connection->expects($this->once())
            ->method('transmit')
            ->will($this->returnValue($response));

        $client = new GuerrillaMail($this->connection);
        $result = $client->deleteEmail($sid_token, array(1, 2, 3));

        $this->assertEquals($response, $result);
    }
}
