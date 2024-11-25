<?php
/*
 * This file is part of the zyan/stock-api.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\StockApi\HttpClient;

use GuzzleHttp\Client;

/**
 * Class HttpClient.
 *
 * @package Zyan\StockApi\HttpClient
 *
 * @author 读心印 <aa24615@qq.com>
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var string
     */
    protected $baseUri = '';
    /**
     * @var array
     */
    protected $config = [];

    protected $client = null;

    /**
     * get.
     *
     * @param string $url
     *
     * @return string|array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function get(string $url, array $query = [])
    {
        $client = $this->client();
        $response = $client->get($url, [
            'query' => $query
        ]);
        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }

    /**
     * client.
     *
     * @return Client
     *
     * @author 读心印 <aa24615@qq.com>
     */
    protected function client()
    {
        if (is_null($this->client)) {
            $defaultConfig = [
                'base_uri' => $this->getBaseUri(),
                'timeout' => 30,
                'http_errors' => false,
                'verify' => false,
            ];

            $config = $defaultConfig + $this->getConfig();
            $this->client = new Client($config);
        }

        return $this->client;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri(string $baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * post.
     *
     * @param string $url
     * @param array $data
     *
     * @return string|array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function post(string $url, array $data)
    {
        $client = $this->client();
        $response = $client->post($url, [
            'form_params' => $data
        ]);
        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }
}
