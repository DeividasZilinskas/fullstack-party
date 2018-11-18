<?php

namespace App\Service\RestClient;

use GuzzleHttp\Client;

/**
 * Class AbstractRestClient
 */
abstract class AbstractRestClient
{
    /**
     * @var string
     */
    protected $ip;

    /**
     * @var Client|null
     */
    private $client;

    /**
     * @var string
     */
    private $authorization;

    /**
     * AbstractRestClient constructor.
     *
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if (is_null($this->client)) {
            $this->client = $this->createClient();
        }

        return $this->client;
    }

    /**
     * @param string $authorization
     *
     * @return AbstractRestClient
     */
    public function setAuthorization(string $authorization): AbstractRestClient
    {
        if ($this->authorization === $authorization) {
            return $this;
        }

        $this->authorization = $authorization;

        // Force to recreate client if auth key changed
        $this->client = null;

        return $this;
    }

    /**
     * @return Client
     */
    protected function createClient(): Client
    {
        $config = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];

        if (!is_null($this->authorization)) {
            $config['headers']['Authorization'] = $this->authorization;
        }

        return new Client($config);
    }

}
