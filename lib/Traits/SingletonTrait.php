<?php

namespace Lib\Traits;

/**
 * Трейт синглтонов
 */
trait SingletonTrait {
    /**
     * @var null|static экземпляр сущности синглтона
     */
    private static $Instance = null;

    /**
     * @return static экземпляр сущности синглтона
     */
    public static function getInstance() {
        if (is_null(self::$Instance)) {
            self::$Instance = new static();
        }
        return self::$Instance;
    }

    private function __construct() {}

    private function __clone() {}
}
