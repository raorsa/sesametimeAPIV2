<?php

use Raorsa\SesameTimeAPIV2\Company;
use Carbon\Carbon;

describe('check', function (): void {

    $token="";
    $companyId='568e0c3e-c230-4e91-89d6-4acdbca5fb54';
    $userId='f2e0bd6a-20ca-4f1f-8d90-e14e9910ffc7';

    $company = new Company($token);

    it('getGroup', function () use($company): void {
        expect($company->getGroup())->toBeArray();
    });

    it('getUsersTime', function () use($company,$companyId): void {
        expect($company->getUsersTime($companyId))->toBeArray();
    });

    it('createEmployer', function () use($company): void {
        expect($company->addEmployer('josevi@raorsa.es','jose','canet',['birthday'=>Carbon::now()]))->toBeArray();
    });

    it('getEmployer', function () use($company,$userId): void {
        expect($company->getEmployer($userId))->toBeArray();
    });

    it('getEmployers', function () use($company): void {
        expect($company->getEmployers())->toBeArray();
    });
});
