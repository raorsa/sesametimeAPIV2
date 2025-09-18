<?php

use Raorsa\SesameTimeAPIV2\Company;

it('company', function (): void {

    $token="";
    $companyId='568e0c3e-c230-4e91-89d6-4acdbca5fb54';

    $company = new Company($token);

    expect(fn(): array => $company->getUsersTime('fail'))->toThrow(Exception::class,'No se ha encontrado la compañia con los datos facilitados.');

    expect(fn(): array => $company->getUsersTime(''))->toThrow(Exception::class,'Te faltan parametros obligatorios');

    expect($company->getGroup())->toBeArray();
    expect($company->getUsersTime($companyId))->toBeArray();

});
