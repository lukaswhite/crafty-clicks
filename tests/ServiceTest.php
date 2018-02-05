<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ServiceTest extends TestCase
{

    public function testClientCreatedAutomatically( )
    {
        $service = new \Lukaswhite\CraftyClicks\Service( 'access token' );

        $reflector = new ReflectionProperty($service, 'client');
        $reflector->setAccessible(true);

        $client = $reflector->getValue( $service );

        $this->assertInstanceOf( Client::class, $client );
        $this->assertEquals( 'http://pcls1.craftyclicks.co.uk', $client->getConfig( 'base_uri' ) );
    }

}