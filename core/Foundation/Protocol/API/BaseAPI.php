<?php

namespace AddPay\Foundation\Protocol\API;

use Exception;

class BaseAPI
{
    /**
     * The config container.
     *
     * @var Config
     */
    public $config;

    /**
     * The base URL for API calls.
     *
     * @var JSONObject
     */
    public $baseUrl;

    /**
     * Basically a bootstrapper for the core API class,
     * ensures config integrity and throws an exception
     * if there are issues with the config.
     *
     * @return void
     *
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            $this->config = $config;
        } else {
            $this->config = json_decode(file_get_contents((is_null($config) ? __DIR__ . '/../../../../config/' : $config) . '/config.json'), true);
        }

        $this->validateConfig();
    }

    /**
     * Pre-allocates the authentication header to be submitted
     * with each API request.
     *
     * @return null
     *
     * @throws Exception If the configuration file is missing required values.
     *
     */
    private function validateConfig()
    {
        if (isset($this->config['open_api'])) {
            if (!isset($this->config['open_api']['client_id']) || !isset($this->config['open_api']['client_secret']) || !isset($this->config['open_api']['public_key'])) {
                throw new Exception("Your configuration file is not setup correctly. Read the documentation.");
            }
        } else {
            throw new Exception("The configuration field 'open_api' is missing. Read the documentation.");
        }

        if (!isset($this->config['logging_enabled'])) {
            $this->config['logging_enabled'] = true;
        }
    }
}
