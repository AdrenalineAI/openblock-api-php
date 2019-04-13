<?php
use PHPUnit\Framework\TestCase;

/**
 * Authenticator Test
 * @author Ahmed Bodiwala <ahmedbodi@crypto-expert.com>
 */
class AuthenticatorTest extends TestCase
{
    /**
     * Test to ensure the authenticator has no syntax errors
     */
    public function testForSyntaxError()
    {
        $var = new OpenBlock\Api\Authenticator("test");
        $this->assertTrue(is_object($var));
    }

    /**
     * Test To Ensure Signing Works With Arrays
     */
    public function testSignArray()
    {
        $data = ['test'];
        $var = new OpenBlock\Api\Authenticator("test");
        $signature = $var->sign($data);
        $this->assertTrue(is_string($signature));
        $this->assertTrue($var->verify($data, $signature));
    }

    /**
     * Test To Ensure Signing Works With Dict's
     */
    public function testSignDictionary()
    {
        $data = ['test' => [1, 2, 3], 'hello' => 'world'];
        $var = new OpenBlock\Api\Authenticator("test");
        $signature = $var->sign($data);
        $this->assertTrue(is_string($signature));
        $this->assertTrue($var->verify($data, $signature));
    }

}
