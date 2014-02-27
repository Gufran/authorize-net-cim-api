<?php namespace Gufran\AuthNet\Entities;


class Configuration {

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->config['mode'];
    }

    /**
     * @return bool
     */
    public function isProduction()
    {
        return $this->getMode() == 'production';
    }

    /**
     * @return bool
     */
    public function isDevelopment()
    {
        return $this->getMode() == 'development';
    }

    /**
     * @return string
     */
    public function getLoginId()
    {
        return $this->config['loginId'];
    }

    /**
     * @return string
     */
    public function getTransactionKey()
    {
        return $this->config['transactionKey'];
    }
} 