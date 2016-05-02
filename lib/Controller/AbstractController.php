<?php

namespace Lib\Controller;

use Lib\Application\Application;

/**
 * Абстрактный контроллер приложения
 */
abstract class AbstractController {
    /**
     * @var Application
     */
    private $Application;

    /**
     * Запуск контроллера
     */
    public abstract function run();

    /**
     * @param Application $Application
     * @return $this
     */
    public function setApplication(Application $Application) {
        $this->Application = $Application;
        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication() {
        return $this->Application;
    }
}
