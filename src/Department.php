<?php

namespace Raorsa\SesameTimeAPIV2;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Exception;
use PASVL\Validation\ValidatorBuilder;

class Department extends Base
{
    private const string GROUP = 'department';

    /**
     * @param string $companyId
     * @return array<string, string>
     * @throws JsonException
     * @throws Exception
     * @throws GuzzleException
     */
    public function getDepartment(string $companyId): array
    {
        return $this->postCall(self::GROUP . '/adm_getDepartments/', ['companyId' => $companyId]);
    }
}

