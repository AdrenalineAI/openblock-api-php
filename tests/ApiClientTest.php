<?php
use PHPUnit\Framework\TestCase;
use Http\Client\Curl\Client;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;

/**
 * ApiClient Test
 * @author Ahmed Bodiwala <ahmedbodi@crypto-expert.com>
 */
class ApiClientTest extends TestCase
{
    public function setUp()
    {
        $client = new Client(MessageFactoryDiscovery::find(), StreamFactoryDiscovery::find());
        $this->authenticator = new OpenBlock\Api\Authenticator("test");
        $this->apiClient = new OpenBlock\Api\ApiClient($this->authenticator);
        $this->apiClient->setClient($client);
    }

    /**
     * Test to ensure the client has no syntax errors
     */
    public function testForSyntaxError()
    {
        $authenticator = new OpenBlock\Api\Authenticator("test");
        $apiClient = new OpenBlock\Api\ApiClient($authenticator);
        $this->assertTrue(is_object($apiClient));
    }

    /**
     * Test To Ensure Sgning Works
     */
    public function testSignRequest()
    {
        $method = "POST";
        $url = "http://localhost/test-sign";
        $nonce = 0;
        $data = ['test'];

        $signature = $this->apiClient->signRequest($method, $url, $nonce, $data);
        $this->assertTrue(is_string($signature));
    }

    /**
     * Test to make sure client can create a request
     */
    public function testRequest()
    {
        $method = "POST";
        $data = ['test'];

        $response = $this->apiClient->request("POST", "register", $data);
        $this->assertNotNull($response);
        $this->assertFalse($response['success']);
    }
}
