<?php

namespace Raorsa\SesameTimeAPIV2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PASVL\Validation\ValidatorBuilder;
use PASVL\Validation\Problems\ArrayFailedValidation;
use JsonException;
use Exception;

abstract class Base
{
    private const string BASE_URL = 'https://api.sesametime.com/v2/';

    private const array RETURN_STRUCTURE = [ "success"=> ":bool", "error"=> ":string? or :array", "data"=> ":string? or :array"];
    protected readonly Client $client;
    public function __construct(private readonly string $token)
    {
        $this->client= new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 2.0,
        ]);
    }

    /**
     * @param array<string, float|int|string|null> $body
     * @throws GuzzleException
     * @throws JsonException
     * @throws ArrayFailedValidation
     * @return array<string, string>
     */
    protected function postCall(string $path, array $body): array{
        return $this->call($path, 'POST', $body);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws ArrayFailedValidation
     * @return array<string, string>
     */
    protected function getCall(string $path): array{
        return $this->call($path, 'GET');
    }

    /**
     * @param array<string, float|int|string|null> $body
     * @throws GuzzleException
     * @throws JsonException
     * @throws ArrayFailedValidation
     * @return array<string, string>
     */
    private function call(string $path, string $method,?array $body=null): array{
        $params = ['headers' => ['Authorization' => "Bearer ".$this->token]];
        if(!is_null($body)){
            $params['body'] = json_encode($body, JSON_THROW_ON_ERROR);
        }
        $response = $this->client->request($method, $path, $params);

        $output= json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $validator = ValidatorBuilder::forArray(self::RETURN_STRUCTURE)->build();
        $validator->validate($output);

        if($output["success"]){
            return $output["data"]??[];
        }
        throw new Exception($output["error"]['message']);
    }
}
