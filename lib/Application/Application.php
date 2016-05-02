<?php

namespace Lib\Application;

use Lib\Config\Config;
use Lib\Controller\AbstractController;
use Lib\Controller\Exception\NotAuthorizedException;

/**
 * Базовый класс приложения
 */
class Application {
    /**
     * @var string среда приложения
     */
    protected $applicationEnvironment = '';

    /**
     * @var string базовая директория приложения
     */
    protected $baseDir = '';

    /**
     * Application constructor.
     * @param string $baseDir
     * @param string $applicationEnvironment dev|prod
     */
    public function __construct($baseDir, $applicationEnvironment) {
        $this->setBaseDir($baseDir);
        $this->setApplicationEnvironment($applicationEnvironment);

        // настраиваем конфиг приложения
        Config::getInstance()->setApplication($this);
    }

    /**
     * Геттер среды запущенного приложения
     * @return string
     */
    public function getApplicationEnvironment() {
        return $this->applicationEnvironment;
    }

    /**
     * Сеттер среды запщуенного приложения
     * @param string $applicationEnvironment
     * @return $this
     */
    protected function setApplicationEnvironment($applicationEnvironment) {
        $this->applicationEnvironment = (string) $applicationEnvironment;
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
