<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class PostcodeLookupTest extends TestCase
{

    public function testLookup( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/SL6-1QZ.xml' ) ),
        ] );

        $container = [ ];
        $history = Middleware::history( $container );

        $stack = HandlerStack::create( $mock );
        $stack->push( $history );

        $client = new Client( [
            'handler'   =>  $stack,
            'base_uri'  => 'http://pcls1.craftyclicks.co.uk',
        ] );

        $service = new \Lukaswhite\CraftyClicks\Service( 'access token', $client );

        $results = $service->postcodeLookup( 'SL6 1QZ' );

        $transaction = $container[ 0 ];

        $this->assertEquals( 'http', $transaction[ 'request' ]->getUri( )->getScheme( ) );
        $this->assertEquals( 'pcls1.craftyclicks.co.uk', $transaction[ 'request' ]->getUri( )->getHost( ) );
        $this->assertEquals( '/xml/rapidaddress', $transaction[ 'request' ]->getUri( )->getPath( ) );
        $this->assertEquals(
            'key=access%20token&postcode=sl61qz&response=data_formatted&lines=3',
            $transaction[ 'request' ]->getUri( )->getQuery( )
        );

        $this->assertTrue( is_array( $results ) );
        $this->assertEquals( 18, count( $results ) );

        $this->assertInstanceOf( \Lukaswhite\CraftyClicks\Models\Address::class, $results[ 0 ] );
        $this->assertNull( $results[ 0 ]->getOrganisationName(  ) );
        $this->assertNull( $results[ 0 ]->getDepartmentName(  ) );
        $this->assertEquals( '1 ST. MARYS WALK', $results[ 0 ]->getLine1( ) );
        $this->assertNull( $results[ 0 ]->getLine2( ) );
        $this->assertNull( $results[ 0 ]->getLine3( ) );
        $this->assertEquals( '22402595', $results[ 0 ]->getUdprn( ) );
        $this->assertEquals( 'MAIDENHEAD', $results[ 0 ]->getTown( ) );
        $this->assertEquals( 'BERKSHIRE', $results[ 0 ]->getPostalCounty( ) );
        $this->assertEquals( 'BERKSHIRE', $results[ 0 ]->getTraditionalCounty( ) );
        $this->assertEquals( 'SL6 1QZ', $results[ 0 ]->getPostcode( ) );

        $this->assertEquals(
            [
                'line_1' => '1 ST. MARYS WALK',
                'town' => 'MAIDENHEAD',
                'postal_county' => 'BERKSHIRE',
                'udprn' => '22402595'
            ], $results[ 0 ]->toArray( ) );

        $this->assertEquals( 'CRAFTY CLICKS LTD', $results[ 16 ]->getOrganisationName( ) );
        $this->assertArrayHasKey( 'organisation_name', $results[ 16 ]->toArray( ) );
        $this->assertEquals( 'CRAFTY CLICKS LTD', $results[ 16 ]->toArray( )[ 'organisation_name' ] );
        $this->assertEquals( 'ST. MARYS WALK', $results[ 16 ]->getLine2( ) );
        $this->assertArrayHasKey( 'line_2', $results[ 16 ]->toArray( ) );
        $this->assertEquals( 'ST. MARYS WALK', $results[ 16 ]->toArray( )[ 'line_2' ] );

        $this->assertEquals( 'FINANCE', $results[ 17 ]->getDepartmentName( ) );
        $this->assertArrayHasKey( 'department_name', $results[ 17 ]->toArray( ) );
        $this->assertEquals( 'FINANCE', $results[ 17 ]->toArray( )[ 'department_name' ] );
        $this->assertEquals( 'ST. MARYS LANE', $results[ 17 ]->getLine3( ) );
        $this->assertArrayHasKey( 'line_3', $results[ 17 ]->toArray( ) );
        $this->assertEquals( 'ST. MARYS LANE', $results[ 17 ]->toArray( )[ 'line_3' ] );

        $json = json_encode( $results[ 0 ] );
        $this->assertEquals(
            $results[ 0 ]->toArray( ),
            json_decode( $json, true )
        );

    }

    public function testSuspendedToken( )
    {
        $this->expectException(\Lukaswhite\CraftyClicks\Exceptions\ServiceException::class);
        $this->expectExceptionMessage('This token is suspended.');
        $this->expectExceptionCode('8005');

        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/suspended-token.xml' ) ),
        ] );

        $stack = HandlerStack::create( $mock );

        $client = new Client( [
            'handler'   =>  $stack,
            'base_uri'  => 'http://pcls1.craftyclicks.co.uk',
        ] );

        $service = new \Lukaswhite\CraftyClicks\Service( 'access token', $client );
        $results = $service->postcodeLookup( 'SL6 1QZ' );


    }

}