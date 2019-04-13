<?php
use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;

/**
 * ApiClient Test
 * @author Ahmed Bodiwala <ahmedbodi@crypto-expert.com>
 */
class ApiClientTest extends TestCase
{
    public function setUp()
    {
        HttpClientDiscovery::prependStrategy(MockClientStrategy::class);
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

        $authenticator = new OpenBlock\Api\Authenticator("test");
        $apiClient = new OpenBlock\Api\ApiClient($authenticator);
        $signature = $apiClient->signRequest($method, $url, $nonce, $data);

        $this->assertTrue(is_string($signature));
    }

    /**
     * Test to make sure client can create a request
     */
    public function testRequest()
    {
        $method = "POST";
        $data = ['test'];

        $authenticator = new OpenBlock\Api\Authenticator("test");
        $apiClient = new OpenBlock\Api\ApiClient($authenticator);
        $response = $apiClient->request("POST", "register", $data);
        $this->assertNull($response);
    }
}
