<?php
use PHPUnit\Framework\TestCase;
use Http\Adapter\Buzz\Client as BuzzAdapter;
use Buzz\Browser;

/**
 * ApiClient Test
 * @author Ahmed Bodiwala <ahmedbodi@crypto-expert.com>
 */
class ApiClientTest extends TestCase
{
    protected static $authenticator;
    protected static $apiClient;
    protected static $username;
    protected static $email;
    protected static $secret;

    public static function setUpBeforeClass()
    {
        $secret = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10);
        $browser = new Browser();
        $client = new BuzzAdapter($browser);
        self::$authenticator = new OpenBlock\Api\Authenticator($secret);
        self::$apiClient = new OpenBlock\Api\ApiClient(self::$authenticator);
        self::$apiClient->setClient($client);

        self::$username = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10);
        self::$email = self::$username . "@test.com";

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

        $signature = self::$apiClient->signRequest($method, $url, $nonce, $data);
        $this->assertTrue(is_string($signature));
    }

    /**
     * Test to make sure client can create a request
     */
    public function testRequest()
    {
        $method = "POST";
        $data = ['test'];

        $response = self::$apiClient->request("POST", "register", $data);
        $this->assertNotNull($response);
        $this->assertFalse($response['success']);
    }

    /**
     * Test For A successful register
     */
    public function testRegister()
    {
        $response = self::$apiClient->register(self::$username, self::$email);
        $this->assertTrue($response['success']);
        $this->assertTrue(count($response['errors']) == 0);
    }

    /**
     * Test for a successful login
     */
    public function testLogin()
    {
        $response = self::$apiClient->login(self::$username);
        $this->assertTrue($response['success']);
        $this->assertTrue(count($response['errors']) == 0);
    }

    /**
     * Test for a successful forgot password request
     */
    public function testForgotPassword()
    {
        $response = self::$apiClient->forgotPassword(self::$email);
        $this->assertTrue($response['success']);
        $this->assertTrue(count($response['errors']) == 0);
        $this->assertEquals($response['data']['email'], self::$email);
    }

}
