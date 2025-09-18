<?php

namespace Raorsa\SesameTimeAPIV2;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Check extends Base
{
    private const string GROUP = 'check';

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @return array<string, string>
     */
    public function create(string $userId, Carbon $date, ?string $type=null, ?string $comment=null): array{
        return $this->postCall(self::GROUP.'/adm_createcheck/', ['userId' => $userId, 'date' => $date->timestamp, 'type' => $type, 'comment' => $comment]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function delete(Carbon $start, Carbon $end, string $userId): bool{
        $this->postCall(self::GROUP.'/adm_deletebetweendates/', ['userId' => $userId, 'start' => $start->timestamp, 'end' => $end->timestamp]);
        return true;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @return array<string, string>
     */
    public function get(?Carbon $start=null, ?Carbon $end=null, ?string $userId=null, ?string $departmentId=null, ?string $companyId=null): array{
        return $this->postCall(self::GROUP.'/adm_getchecksbywhere/', ['userId' => $userId,'departmentId' => $departmentId,'companyId' => $companyId,'startAt'=>$start->timestamp??null,'endAt'=>$end->timestamp??null ]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @return array<string, string>
     */
    public function update(string $checkId, Carbon $date, ?string $comment=null): array{
        return $this->postCall(self::GROUP.'/adm_updateCheck/', ['checkId' => $checkId,'date'=>$date->timestamp,'comment' => $comment ]);
    }
}

