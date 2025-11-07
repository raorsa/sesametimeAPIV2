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
    public function create(string $userId, Carbon $date, ?string $type = null, ?string $comment = null): array
    {
        return $this->postCall(self::GROUP . '/adm_createcheck/', ['userId' => $userId, 'date' => $date->timestamp, 'type' => $type, 'comment' => $comment]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function delete(Carbon $start, Carbon $end, string $userId): bool
    {
        $this->postCall(self::GROUP . '/adm_deletebetweendates/', ['userId' => $userId, 'start' => $start->timestamp, 'end' => $end->timestamp]);
        return true;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @return array<string, string>
     */
    public function get(?Carbon $start = null, ?Carbon $end = null, ?string $userId = null, ?string $departmentId = null, ?string $companyId = null): array
    {
        return $this->postCall(self::GROUP . '/adm_getchecksbywhere/', ['userId' => $userId, 'departmentId' => $departmentId, 'companyId' => $companyId, 'startAt' => $start->timestamp ?? null, 'endAt' => $end->timestamp ?? null]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @return array<string, string>
     */
    public function update(string $checkId, Carbon $date, ?string $comment = null): array
    {
        return $this->postCall(self::GROUP . '/adm_updateCheck/', ['checkId' => $checkId, 'date' => $date->timestamp, 'comment' => $comment]);
    }

    /**
     * @return array<string, string>
     */
    public static function mergeChecksSessions(array $checks): array
    {
        $merged = [];
        $output = [];

        foreach ($checks as $check) {
            if (!isset($merged[$check["Check"]["user_id"]])) {
                $merged[$check["Check"]["user_id"]] = [1 => [], 2 => []];
            }
            $merged[$check["Check"]["user_id"]][count($merged[$check["Check"]["user_id"]][1]) > count($merged[$check["Check"]["user_id"]][2]) ? 2 : 1][] = $check["Check"]["date"];
        }
        foreach ($merged as $user_id => $checks) {
            for ($i = 0; $i < count($checks[1]); $i++) {
                $start = Carbon::parse($checks[1][$i]);
                if (isset($checks[2][$i])) {
                    $end = Carbon::parse($checks[2][$i]);
                    $diff = $start->diffInSeconds($end);
                } else {
                    $diff = 0;
                }

                $day = (string) $start->format('Y-m-d');
                if (!isset($output[$user_id][$day])) {
                    $output[$user_id][$day] = [];
                }
                $output[$user_id][$day][] = $diff;
            }
        }
        return $output;
    }

    /**
     * @return array<string, string>
     */
    public static function mergeChecksDays(array $checks): array
    {
        $merged = self::mergeChecksSessions($checks);
        $output = [];

        foreach ($merged as $user_id => $checks) {
            foreach ($checks as $day => $diffs) {
                $output[$user_id][$day] = array_sum($diffs);
            }
        }
        return $output;
    }
}

