<?php

namespace DevDizs\PayappWs\PayappHandlers;

class Config
{
    protected $config;

    public function __construct()
    {
        // Load default configuration
        $defaultConfig = require __DIR__ . '/../../config/payappws.php';

        $publishedConfigPath = getcwd() . '/config/payappws.php';
        $publishedConfig = file_exists( $publishedConfigPath ) ? require $publishedConfigPath : [];

        $this->config = array_merge( $defaultConfig, $publishedConfig );
    }

    public function getConfig( $key )
    {
        return $this->config[ $key ] ?? null;
    }
}