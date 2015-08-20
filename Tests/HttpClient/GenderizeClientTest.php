<?php

namespace Jhg\GenderizeIoClient\Tests\HttpClient;

use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Jhg\GenderizeIoClient\HttpClient\GenderizeClient;
use \Mockery as m;

/**
 * Class GenderizeClientTest
 * 
 * @package Jhg\GenderizeIoClient\Tests\HttpClient
 */
class GenderizeClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getRateLimit method default value
     */
    public function testDefaultRateLimit()
    {
        $client = new GenderizeClient();
        $this->assertNull($client->getRateLimit());
    }

    /**
     * Tests getRateRemainingLimit method default value
     */
    public function testDefaultRateRemainingLimit()
    {
        $client = new GenderizeClient();
        $this->assertNull($client->getRateRemainingLimit());
    }

    /**
     * Tests getRateReset method default value
     */
    public function testDefaultRateReset()
    {
        $client = new GenderizeClient();
        $this->assertNull($client->getRateReset());
    }

    /**
     * Tests getRateLimit method
     */
    public function testRateLimit()
    {
        $response = new Response(200);
        $response->setHeader('X-Rate-Limit-Limit', '100');

        $client = new GenderizeClient();
        $client->setLastResponse($response);
        $this->assertEquals('100', $client->getRateLimit());
    }

    /**
     * Tests getRateRemainingLimit method
     */
    public function testRateRemainingLimit()
    {
        $response = new Response(200);
        $response->setHeader('X-Rate-Limit-Remaining', '100');

        $client = new GenderizeClient();
        $client->setLastResponse($response);
        $this->assertEquals('100', $client->getRateRemainingLimit());
    }

    /**
     * Tests getRateReset method
     */
    public function testRateReset()
    {
        $response = new Response(200);
        $response->setHeader('X-Rate-Reset', '100');

        $client = new GenderizeClient();
        $client->setLastResponse($response);
        $this->assertEquals('100', $client->getRateReset());
    }

    /**
     * Tests genderize method
     */
    public function testGenderize()
    {
        $requestMock = m::mock('Guzzle\Http\Message\Request');
        $requestMock->shouldReceive('send')->andReturn(new Response(200));

        $clientPartialMock = m::mock('Jhg\GenderizeIoClient\HttpClient\GenderizeClient[get]');
        $clientPartialMock->shouldReceive('get')->andReturn($requestMock);
        $json = $clientPartialMock->genderize(['country_id'=>'es']);

        $this->assertTrue(is_array($json));
    }
}