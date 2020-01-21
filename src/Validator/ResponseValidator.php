<?php

namespace RestApi\Validator;

use RestApi\Exception\AddressNotFoundException;
use RestApi\Exception\AuthenticationException;
use RestApi\Exception\InputInvalidException;
use RestApi\Exception\ServiceException;

class ResponseValidator
{
    const SECRET_ERROR            = 'PostcodeNl_Controller_Plugin_HttpBasicAuthentication_PasswordNotCorrectException';
    const KEY_ERROR               = 'PostcodeNl_Controller_Plugin_HttpBasicAuthentication_NotAuthorizedException';
    const ADDRESS_NOT_FOUND_ERROR = 'PostcodeNl_Service_PostcodeAddress_AddressNotFoundException';

    const SERVICE_UNAVAILABLE_MSG = 'Service Unavailable';
    const JSON_MSG                = 'Invalid JSON';
    const SECRET_MSG              = 'Invalid secret';
    const KEY_MSG                 = 'Invalid key';
    const ADDRESS_NOT_FOUND_MSG   = 'Address not found';
    const AUTH_MSG                = 'Authentication failed';
    const INPUT_MSG               = 'Invalid input';
    const GENERIC_MSG             = 'Error occurred';

    public function validate(int $statusCode, ?string $exceptionId): void
    {
        if ($statusCode === 200 && !$exceptionId) {
            return;
        }

        switch (true) {
            case $statusCode === 503 && !$exceptionId:
                throw new AuthenticationException(self::SERVICE_UNAVAILABLE_MSG);
            case !$exceptionId:
                throw new ServiceException(self::JSON_MSG);
            case $exceptionId === self::SECRET_ERROR:
                throw new AuthenticationException(self::SECRET_MSG);
            case $exceptionId === self::KEY_ERROR:
                throw new AuthenticationException(self::KEY_MSG);
            case $exceptionId === self::ADDRESS_NOT_FOUND_ERROR:
                throw new AddressNotFoundException(self::ADDRESS_NOT_FOUND_MSG);
            case $statusCode === 401 || $statusCode === 403:
                throw new AuthenticationException(self::AUTH_MSG);
            case $statusCode === 400:
                throw new InputInvalidException(self::INPUT_MSG);
            default:
                throw new ServiceException(self::GENERIC_MSG);
        }
    }
}
