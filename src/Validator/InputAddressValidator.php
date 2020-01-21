<?php

namespace RestApi\Validator;

use RestApi\Exception\InputInvalidException;

class InputAddressValidator
{
    const POSTCODE_REGEX = '~^[1-9][0-9]{3}[a-zA-Z]{2}$~';

    const POSTCODE_MSG = 'Postcode needs to be in the 1234AB format';

    public function validate(string $postcode, int $houseNumber): void
    {
        switch (true) {
            case !(boolean)preg_match(self::POSTCODE_REGEX, $postcode):
                throw new InputInvalidException(self::POSTCODE_MSG);
        }
    }
}
