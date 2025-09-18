<?php

use Raorsa\SesameTimeAPIV2\Check;

it('check', function (): void {

    $token="";
    $userId='f2e0bd6a-20ca-4f1f-8d90-e14e9910ffc7';
    $checkId='5b256efa-8b35-42ae-87bd-76f6e338f305';

    $check = new Check($token);

    expect(fn(): array => $check->create('fail',\Carbon\Carbon::now()))->toThrow(Exception::class,'No se ha encontrado ningún usuario con los datos facilitados.');

    expect(fn(): array => $check->create('',\Carbon\Carbon::now()))->toThrow(Exception::class,'Te faltan parametros obligatorios');
    expect(fn(): bool => $check->delete(\Carbon\Carbon::now(),\Carbon\Carbon::now(),''))->toThrow(Exception::class,'Te faltan parametros obligatorios');
    expect(fn(): array => $check->update('',\Carbon\Carbon::now()))->toThrow(Exception::class,'Te faltan parametros obligatorios');

    expect($check->create($userId,\Carbon\Carbon::now()))->toBeArray();
    expect($check->delete(\Carbon\Carbon::now(),\Carbon\Carbon::now()->addHours(1),$userId))->toBeTrue();
    expect($check->get())->toBeArray();
    expect($check->update($checkId,\Carbon\Carbon::now()))->toBeArray();
});
