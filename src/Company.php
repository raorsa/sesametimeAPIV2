<?php

namespace Raorsa\SesameTimeAPIV2;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Exception;

class Company extends Base
{
    private const string GROUP = 'company';

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     * @return array<string, string>
    */
    public function getGroup(): array{
        return $this->getCall(self::GROUP.'/adm_getCompaniesGroup/');
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     * @return array<string, string>
     */
    public function getUsersTime(string $companyId,?Carbon $start=null, ?Carbon $end=null): array{
        return $this->postCall(self::GROUP.'/adm_getUsersTime/',['companyId' => $companyId,'startAt'=>$start->timestamp??null,'endAt'=>$end->timestamp??null ]);
    }
}

