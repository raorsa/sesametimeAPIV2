<?php

namespace Raorsa\SesameTimeAPIV2;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Exception;
use PASVL\Validation\ValidatorBuilder;

class Customer extends Base
{
    private const string GROUP = 'customer';

    private const array CUSTOMER_STRUCTURE = [
        "firstName" => ":string",
        "companyName" => ":string",
        "lastName" => ":string",
        "email" => ":string",
        "phone" => ":string",
        "companyId" => ":string",
        "description" => ":string",
    ];

    /**
     * @return array<string, string>
     * @throws JsonException
     * @throws Exception
     * @throws GuzzleException
     */
    public function getCustomers(): array
    {
        return $this->getCall(self::GROUP . '/adm_getCustomers');
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param array<string>|null $data
     * @return array<string, string>
     * @throws GuzzleException
     * @throws JsonException
     */
    public function addEmployer(string $firstName, string $lastName, ?array $data = []): array
    {
        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;

        $validator = ValidatorBuilder::forArray(self::CUSTOMER_STRUCTURE)->build();
        $validator->validate($data);

        return $this->postCall(self::GROUP . '/adm_create', $data);
    }
}

