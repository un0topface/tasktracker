<?php

namespace Lib\Connection\ConnectionFactory;

use alxmsl\Connection\Postgresql\Connection;
use alxmsl\Connection\Predis\PredisFactory;
use Lib\Config\Config;
use Lib\Traits\SingletonTrait;
use Predis\Client;

/**
 * Фабрика подключений
 */
final class ConnectionFactory {
    use SingletonTrait;

    /**
     * Создает подключение к постгресу по его имени из конфига
     * @param string $configName
     * @return Connection
     */
    public function createPostgresByConfig($configName) {
        // Create connection
        $Connection = new Connection();
        $Connection->setUserName(Config::getInstance()->get('database', $configName)['username'])
                   ->setPassword(Config::getInstance()->get('database', $configName)['password'])
                   ->setDatabase(Config::getInstance()->get('database', $configName)['database'])
                   ->setHost(Config::getInstance()->get('database', $configName)['host'])
                   ->setPort(Config::getInstance()->get('database', $configName)['port']);
        return $Connection;
    }

    /**
     * Создает подключение к редису по его имени из конфига
     * @param $configName
     * @return Client
     */
    public function createPredisByConfig($configName) {
        $Connection = PredisFactory::createPredisByConfig(
            Config::getInstance()->get('redis', $configName)
        );

        return $Connection;
    }
}
