<?php

namespace Raorsa\SesameTimeAPIV2;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Exception;
use PASVL\Validation\ValidatorBuilder;
use PASVL\Validation\Rules\Library\RuleObject;

class Company extends Base
{
    private const string GROUP = 'company';

    private const array EMPLOYER_STRUCTURE = [
        "email"=> ":string :email",
        "name"=> ":string",
        "surname"=> ":string",
        "active?"=> ":bool",
        "pin?"=>":int",
        "password?"=>":string",
        "birthday?"=>":object :instance('Carbon\Carbon')" ,
        "group?"=>":string",
        "up?"=>":bool",
        "code?"=>":int",
        "invited?"=>":bool",
        "departmentId?"=>":string"
    ];

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

    /**
     * @param string $email
     * @param string $name
     * @param string $surname
     * @param array<string, float|int|string|null>|null $data
     * @return array<string, string>
     * @throws GuzzleException
     * @throws JsonException
     */
    public function addEmployer(string $email, string $name, string $surname, ?array $data=[]): array{
        $data['email'] = $email;
        $data['name'] = $name;
        $data['surname'] = $surname;

        $validator = ValidatorBuilder::forArray(self::EMPLOYER_STRUCTURE)->build();
        $validator->validate($data);

        if(isset($data['birthday'])){
            $data['birthday'] = (string)$data['birthday']->format('Y-m-d');
        }

        return $this->postCall(self::GROUP.'/createEmployer/',$data);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     * @return array<string, string>
     */
    public function getEmployer(string $userId): array{
        return $this->postCall(self::GROUP.'/getEmployer/',['userId' => $userId]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     * @return array<string, string>
     */
    public function getEmployers(): array{
        return $this->getCall(self::GROUP.'/getEmployers/');
    }

}

