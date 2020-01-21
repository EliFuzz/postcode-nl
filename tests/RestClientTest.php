<?php

use PHPUnit\Framework\TestCase;
use RestApi\RestClient;

class RestClientTest extends TestCase
{
    private $stub;

    /** @test */
    public function validAddress()
    {
        $response = [
            "street"                 => "Julianastraat",
            "streetNen"              => "Julianastraat",
            "houseNumber"            => 30,
            "houseNumberAddition"    => "",
            "postcode"               => "2012ES",
            "city"                   => "Haarlem",
            "cityShort"              => "Haarlem",
            "municipality"           => "Haarlem",
            "municipalityShort"      => "Haarlem",
            "province"               => "Noord-Holland",
            "rdX"                    => 103242,
            "rdY"                    => 487716,
            "latitude"               => 52.37487801,
            "longitude"              => 4.62714526,
            "bagNumberDesignationId" => "0392200000029398",
            "bagAddressableObjectId" => "0392010000029398",
            "addressType"            => "building",
            "purposes"               => [
                "office",
            ],
            "surfaceArea"            => 643,
            "houseNumberAdditions"   => [
                "",
            ],
        ];
        $this->stub->method('lookupAddress')
                   ->with('2012ES', 30)
                   ->willReturn($response);

        $this->assertEquals($response, $this->stub->lookupAddress('2012ES', 30));
    }

    protected function setUp(): void
    {
        $this->stub = $this->getMockBuilder(RestClient::class)
                           ->setConstructorArgs(['key', 'secret'])
                           ->getMock();
    }

    protected function tearDown(): void
    {
        $this->stub = null;
    }
}
