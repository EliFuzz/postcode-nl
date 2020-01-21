<?php

use PHPUnit\Framework\TestCase;
use RestApi\Exception\AddressNotFoundException;
use RestApi\Exception\AuthenticationException;
use RestApi\Exception\InputInvalidException;
use RestApi\Exception\ServiceException;
use RestApi\Validator\ResponseValidator;

class ResponseValidatorTest extends TestCase
{
    private $responseValidator;

    /** @test */
    public function valid()
    {
        $this->assertNull($this->responseValidator->validate(200, ''));
    }

    /** @test */
    public function serviceUnavailable()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(ResponseValidator::SERVICE_UNAVAILABLE_MSG);

        $this->responseValidator->validate(503, '');
    }

    /** @test */
    public function invalidResponseJson()
    {
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage(ResponseValidator::JSON_MSG);

        $this->responseValidator->validate(501, '');
    }

    /** @test */
    public function invalidSecret()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(ResponseValidator::SECRET_MSG);

        $this->responseValidator->validate(500, ResponseValidator::SECRET_ERROR);
    }

    /** @test */
    public function invalidKey()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(ResponseValidator::KEY_MSG);

        $this->responseValidator->validate(500, ResponseValidator::KEY_ERROR);
    }

    /** @test */
    public function invalidAddress()
    {
        $this->expectException(AddressNotFoundException::class);
        $this->expectExceptionMessage(ResponseValidator::ADDRESS_NOT_FOUND_MSG);

        $this->responseValidator->validate(500, ResponseValidator::ADDRESS_NOT_FOUND_ERROR);
    }

    /** @test */
    public function invalidAuthentication401()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(ResponseValidator::AUTH_MSG);

        $this->responseValidator->validate(401, ' ');
    }

    /** @test */
    public function invalidAuthentication403()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(ResponseValidator::AUTH_MSG);

        $this->responseValidator->validate(403, ' ');
    }

    /** @test */
    public function invalidInput()
    {
        $this->expectException(InputInvalidException::class);
        $this->expectExceptionMessage(ResponseValidator::INPUT_MSG);

        $this->responseValidator->validate(400, ' ');
    }

    /** @test */
    public function genericException()
    {
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage(ResponseValidator::GENERIC_MSG);

        $this->responseValidator->validate(404, ' ');
    }

    protected function setUp(): void
    {
        $this->responseValidator = new ResponseValidator();
    }

    protected function tearDown(): void
    {
        $this->responseValidator = null;
    }
}
