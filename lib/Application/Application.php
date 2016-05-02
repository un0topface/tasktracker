<?php

namespace Lib\Application;

use Lib\Controller\AbstractController;
use Lib\Controller\Exception\NotAuthorizedException;

/**
 * Базовый класс приложения
 */
class Application {
    /**
     * @var string папка конфига приложения
     */
    protected $configDir = '';

    /**
     * @var string базовая директория приложения
     */
    protected $baseDir = '';

    /**
     * Application constructor.
     * @param $baseDir
     */
    public function __construct($baseDir) {
        $this->setBaseDir($baseDir);
    }

    /**
     * Геттер папки конфига приложения
     * @return array
     */
    public function getConfigDir() {
        return $this->configDir;
    }

    /**
     * Сеттер папки конфига приложения
     * @param string $configDir
     * @return $this
     */
    public function setConfigDir($configDir) {
        $this->configDir = (string) $configDir;
        return $this;
    }

    /**
     * Запускает выбранный контроллер приложения
     */
    public function run() {
        /** @var AbstractController $Controller */
        try {
            $controllerName = str_replace('.', '\\', $_SERVER['controller']);

            $Controller = new $controllerName();
            $Controller->setApplication($this);
            $Controller->run();
        } catch (NotAuthorizedException $Ex) {
            header('Location: /login');
            return;
        }
    }

    /**
     * @return string
     */
    public function getBaseDir() {
        return $this->baseDir;
    }

    /**
     * @param string $baseDir
     * @return $this
     */
    protected function setBaseDir($baseDir) {
        $this->baseDir = $baseDir;
        return $this;
    }
}
