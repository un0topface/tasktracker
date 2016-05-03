<?php

define('APPLICATION_ENV', 'prod');

// базовая директория приложения
$baseDir = __DIR__ . '/';

// грузим автолоадер
include $baseDir . 'vendor/autoload.php';

// создаем объект с приложением
$Application = new \Lib\Application\Application($baseDir, APPLICATION_ENV);
// запускаем приложение
$Application->run();
