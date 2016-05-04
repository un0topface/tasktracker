<?php

namespace Lib\Config;

use Lib\Application\Application;
use Lib\Config\Exception\ConfigNotFoundException;
use Lib\Traits\SingletonTrait;
use RuntimeException;

/**
 * Класс конфига приложения
 */
final class Config {
    use SingletonTrait;

    /**
     * @var Application экземпляр текущего приложения
     */
    private $Application;

    /**
     * @var array кэш конфига
     */
    private $configMap = [];

    /**
     * Получает массив с конфигом в определенном файле
     * @param string $configName имя конфига
     * @param null|string $option ключ в конфиге
     * @return mixed конфиг или ключ из него
     * @throws ConfigNotFoundException
     */
    public function get($configName, $option = null) {
        // приложение должно быть назначено
        if (empty($this->getApplication())) {
            throw new RuntimeException('Application must be created before config');
        }

        // если есть в кэше - возвращаем из кэша
        if (!isset($configMap[$configName])) {
            // папка с конфигом данного приложения
            $configFolder = sprintf(
                '%sconfig/%s',
                $this->getApplication()->getBaseDir(),
                $this->getApplication()->getApplicationEnvironment()
            );

            // загружаем конфиг из файла
            if (file_exists($configFile = sprintf('%s/%s.php', $configFolder, $configName))) {
                // если файл существует для конкретной среды исполнения, то считываем в кэш его
                $this->configMap[$configName] = include $configFile;
            } elseif (file_exists($configFile = sprintf('%s/../%s.php', $configFolder, $configName))) {
                // иначе смотрим в директорию выше - конфигов для всех сред исполнения
                $this->configMap[$configName] = include $configFile;
            } else {
                throw new ConfigNotFoundException(
                    'Config ' . $configName . ' not found in ' . $configFolder . ' and above'
                );
            }
        }

        // если хотим получить конкретный ключ внутри конфига
        if (!is_null($option)) {
            return $this->configMap[$configName][$option];
        } else {
            return $this->configMap[$configName];
        }
    }

    /**
     * Геттер текущего приложения
     * @return Application
     */
    private function getApplication() {
        return $this->Application;
    }

    /**
     * Сеттер текущего приложения
     * @param string $Application
     * @return $this
     */
    public function setApplication($Application) {
        $this->Application = $Application;
        return $this;
    }
}
