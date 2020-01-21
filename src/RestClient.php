<?php

namespace RestApi;

use RestApi\HtttpClient\HttpClient;
use RestApi\Validator\InputAddressValidator;
use RestApi\Validator\ResponseValidator;

class RestClient
{
    const BASE_URL    = 'https://api.postcode.nl/rest/';
    const ADDRESS_URL = 'addresses/postcode/';

    private $client;
    private $addressInputValidator;
    private $responseValidator;

    public function __construct(string $key, string $secret)
    {
        $this->client = new HttpClient();
        $this->client->setConfigs(['auth' => [$key, $secret]]);

        $this->addressInputValidator = new InputAddressValidator();
        $this->responseValidator = new ResponseValidator();
    }

    public function setHttpConfigs(array $configs): void
    {
        $this->client->setConfigs($configs);
    }

    /**
     * @param string $postcode
     * @param int    $houseNumber
     * @param string $houseNumberAddition
     *
     * @return array
     * @throws Exception\AddressNotFoundException
     * @throws Exception\AuthenticationException
     * @throws Exception\InputInvalidException
     * @throws Exception\ServiceException
     */
    public function lookupAddress(string $postcode, int $houseNumber, string $houseNumberAddition = ''): array
    {
        $this->addressInputValidator->validate($postcode, $houseNumber);

        $response = $this->client->doGet(self::BASE_URL.self::ADDRESS_URL.rawurlencode($postcode)."/$houseNumber/".rawurlencode($houseNumberAddition));

        $this->responseValidator->validate($response['statusCode'], $response['body']['exceptionId']);

        return $response['body'];
    }
}
