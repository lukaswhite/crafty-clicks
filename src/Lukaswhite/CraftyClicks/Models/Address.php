<?php namespace Lukaswhite\CraftyClicks\Models;

/**
 * Class Address
 *
 * @package Lukaswhite\CraftyClicks\Models
 */
class Address implements \JsonSerializable
{
    /**
     * The name of the organisation, if applicable
     *
     * @var string
     */
    private $organisationName;

    /**
     * The name of the department, if applicable
     *
     * @var string
     */
    private $departmentName;

    /**
     * The first line of the address
     *
     * @var string
     */
    private $line1;

    /**
     * The second line of the address
     *
     * @var string
     */
    private $line2;

    /**
     * The third line of the address
     *
     * @var string
     */
    private $line3;

    /**
     * The Unique Delivery Point Reference Number
     *
     * @var string
     */
    private $udprn;

    /**
     * The name of the town
     *
     * @var string
     */
    private $town;

    /**
     * The postal name of the county
     *
     * @var string
     */
    private $postalCounty;

    /**
     * The traditional name of the county
     *
     * @var string
     */
    private $traditionalCounty;

    /**
     * The postcode
     *
     * @var string
     */
    private $postcode;

    /**
     * @return string
     */
    public function getOrganisationName(): ?string
    {
        return $this->organisationName;
    }

    /**
     * @param string $organisationName
     * @return Address
     */
    public function setOrganisationName( string $organisationName ): Address
    {
        $this->organisationName = $organisationName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    /**
     * @param string $departmentName
     * @return Address
     */
    public function setDepartmentName( string $departmentName ): Address
    {
        $this->departmentName = $departmentName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine1(): string
    {
        return $this->line1;
    }

    /**
     * @param string $line1
     * @return Address
     */
    public function setLine1( string $line1 ): Address
    {
        $this->line1 = $line1;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine2(): ?string
    {
        return $this->line2;
    }

    /**
     * @param string $line2
     * @return Address
     */
    public function setLine2( string $line2 ): Address
    {
        $this->line2 = $line2;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine3(): ?string
    {
        return $this->line3;
    }

    /**
     * @param string $line3
     * @return Address
     */
    public function setLine3( string $line3 ): Address
    {
        $this->line3 = $line3;
        return $this;
    }

    /**
     * @return string
     */
    public function getUdprn(): ?string
    {
        return $this->udprn;
    }

    /**
     * @param string $udprn
     * @return Address
     */
    public function setUdprn( string $udprn ): Address
    {
        $this->udprn = $udprn;
        return $this;
    }

    /**
     * @return string
     */
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @param string $town
     * @return Address
     */
    public function setTown( string $town ): Address
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCounty(): string
    {
        return $this->postalCounty;
    }

    /**
     * @param string $postalCounty
     * @return Address
     */
    public function setPostalCounty( string $postalCounty ): Address
    {
        $this->postalCounty = $postalCounty;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraditionalCounty(): ?string
    {
        return $this->traditionalCounty;
    }

    /**
     * @param string $traditionalCounty
     * @return Address
     */
    public function setTraditionalCounty( string $traditionalCounty ): Address
    {
        $this->traditionalCounty = $traditionalCounty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     * @return Address
     */
    public function setPostcode( $postcode )
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * Create an array representation of this address
     *
     * @return array
     */
    public function toArray( )
    {
        $arr = [ ];

        if ( $this->organisationName ) {
            $arr[ 'organisation_name' ] = $this->organisationName;
        }

        if ( $this->departmentName ) {
            $arr[ 'department_name' ] = $this->departmentName;
        }

        if ( $this->line1 ) {
            $arr[ 'line_1' ] = $this->line1;
        }

        if ( $this->line2 ) {
            $arr[ 'line_2' ] = $this->line2;
        }

        if ( $this->line3 ) {
            $arr[ 'line_3' ] = $this->line3;
        }

        if ( $this->town ) {
            $arr[ 'town' ] = $this->town;
        }

        if ( $this->postalCounty ) {
            $arr[ 'postal_county' ] = $this->postalCounty;
        }

        if ( $this->organisationName ) {
            $arr[ 'traditional_county' ] = $this->traditionalCounty;
        }

        if ( $this->udprn ) {
            $arr[ 'udprn' ] = $this->udprn;
        }

        return $arr;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize( )
    {
        return $this->toArray( );
    }


}