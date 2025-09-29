<?php

use Raorsa\SesameTimeAPIV2\Check;


describe('check', function (): void {

    $token="";
    $userId='f2e0bd6a-20ca-4f1f-8d90-e14e9910ffc7';
    $checkId='5b256efa-8b35-42ae-87bd-76f6e338f305';

    $check = new Check($token);

    it('userId no valid', function () use($check): void {
        expect(fn(): array => $check->create('fail',\Carbon\Carbon::now()))->toThrow(Exception::class,'No se ha encontrado ningún usuario con los datos facilitados.');
    });

    it('userId no set', function () use($check): void {
        expect(fn(): bool => $check->delete(\Carbon\Carbon::now(),\Carbon\Carbon::now(),''))->toThrow(Exception::class,'Te faltan parametros obligatorios');
    });

    it('create', function () use($check,$userId): void {
        expect($check->create($userId,\Carbon\Carbon::now()))->toBeArray();
    });

    it('update', function () use($check,$checkId): void {
        expect($check->update($checkId,\Carbon\Carbon::now()))->toBeArray();
    });

    it('get', function () use($check): void {
        expect($check->get())->toBeArray();
    });

    it('delete', function () use($check,$userId): void {
        expect($check->delete(\Carbon\Carbon::now(),\Carbon\Carbon::now()->addHours(1),$userId))->toBeTrue();
    });

});

