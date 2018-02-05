<?php namespace Lukaswhite\CraftyClicks;

use GuzzleHttp\Client;
use Lukaswhite\CraftyClicks\Exceptions\ServiceException;
use Lukaswhite\CraftyClicks\Models\Address;

/**
 * Class Service
 *
 * @package Lukaswhite\CraftyClicks
 */
class Service
{
    /**
     * The access token
     *
     * @var string
     */
    private $accessToken;

    /**
     * Service constructor.
     */
    public function __construct( $accessToken, $client = null )
    {
        $this->accessToken = $accessToken;
        if ( ! $client ) {
            $this->client = new Client( [
                'base_uri'  => 'http://pcls1.craftyclicks.co.uk',
            ] );
        } else {
            $this->client = $client;
        }
    }

    /**
     * Lookup a postcode
     *
     * @var string $postcode
     * @return array
     * @throws ServiceException
     */
    public function postcodeLookup( $postcode )
    {
        $response = $this->client->get(
            'xml/rapidaddress',
            [
                'query' =>  [
                    'key'       =>  $this->accessToken,
                    'postcode'  =>  strtolower( trim( str_replace( ' ', '', $postcode ) ) ),
                    'response'  => 'data_formatted',
                    'lines'     =>  3,
                ],
            ]
        );

        $xml = simplexml_load_string( ( string ) $response->getBody( ) );

        if ( $xml->error_code ) {
            throw new ServiceException( ( string ) $xml->error_msg, ( string ) $xml->error_code );
        }

        $town = ( string ) $xml->address_data_formatted->town;
        $postcode = ( string ) $xml->address_data_formatted->postcode;
        $postalCounty = ( string ) $xml->address_data_formatted->postal_county;
        $traditionalCounty = ( string ) $xml->address_data_formatted->traditional_county;

        $addresses = [ ];

        foreach( $xml->address_data_formatted->delivery_point as $el )
        {
            $address = ( new Address( ) )
                ->setTown( $town )
                ->setPostalCounty( $postalCounty )
                ->setTraditionalCounty( $traditionalCounty )
                ->setPostcode( $postcode );

            if ( $el->organisation_name && strlen( ( string ) $el->organisation_name ) ) {
                $address->setOrganisationName( ( string ) $el->organisation_name );
            }

            if ( $el->department_name && strlen( ( string ) $el->department_name ) ) {
                $address->setDepartmentName( ( string ) $el->department_name );
            }

            if ( $el->line_1 && strlen( ( string ) $el->line_1 ) ) {
                $address->setLine1( ( string ) $el->line_1 );
            }

            if ( $el->line_2 && strlen( ( string ) $el->line_2 ) ) {
                $address->setLine2( ( string ) $el->line_2 );
            }

            if ( $el->line_3 && strlen( ( string ) $el->line_3 ) ) {
                $address->setLine3( ( string ) $el->line_3 );
            }

            if ( $el->udprn && strlen( ( string ) $el->udprn ) ) {
                $address->setUdprn( ( string ) $el->udprn );
            }

            $addresses[ ] = $address;
        }

        return $addresses;
    }
}