<?php

/*
 * This file is part of the StyleCI SDK.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\SDK;

use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\ClientInterface;

/**
 * This is the client class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Client
{
    /**
     * The base url.
     *
     * @var string
     */
    const BASE_URL = 'https://api.styleci.io/';

    /**
     * The user agent.
     *
     * @var string
     */
    const USER_AGENT = 'styleci-sdk/1.3';

    /**
     * The guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Create a new client instance.
     *
     * @param \GuzzleHttp\ClientInterface|null $client
     *
     * @return void
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: GuzzleFactory::make([
            'base_uri' => static::BASE_URL,
            'headers'  => ['Accept' => 'application/json', 'User-Agent' => static::USER_AGENT],
        ]);
    }

    /**
     * Get the fixers.
     *
     * @return array
     */
    public function fixers()
    {
        return $this->get('fixers');
    }

    /**
     * Get the presets.
     *
     * @return array
     */
    public function presets()
    {
        return $this->get('presets');
    }

    /**
     * Validate the given config.
     *
     * @param string $config
     *
     * @return array
     */
    public function validate($config)
    {
        return $this->get('validate', ['query' => ['config' => $config]]);
    }

    /**
     * Generate rules from the given config.
     *
     * @param string $config
     *
     * @return array
     */
    public function rules($config)
    {
        return $this->get('rules', ['query' => ['config' => $config]]);
    }

    /**
     * Send a get request, and parse the result as json.
     *
     * @param string $uri
     *
     * @return array
     */
    protected function get($uri)
    {
        $response = $this->client->request('GET', $uri);

        return json_decode($response->getBody(), true);
    }
}
