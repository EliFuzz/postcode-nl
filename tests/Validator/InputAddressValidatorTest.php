<?php

use PHPUnit\Framework\TestCase;
use RestApi\Exception\InputInvalidException;
use RestApi\Validator\InputAddressValidator;

class InputAddressValidatorTest extends TestCase
{
    private $addressValidator;

    /** @test */
    public function validInputAddress()
    {
        $this->assertNull($this->addressValidator->validate('1234AB', 123));
    }

    /** @test */
    public function invalidPostcode()
    {
        $this->expectException(InputInvalidException::class);
        $this->expectExceptionMessage(InputAddressValidator::POSTCODE_MSG);

        $this->addressValidator->validate('1234 AB', 123);
    }

    protected function setUp(): void
    {
        $this->addressValidator = new InputAddressValidator();
    }

    protected function tearDown(): void
    {
        $this->addressValidator = null;
    }
}
