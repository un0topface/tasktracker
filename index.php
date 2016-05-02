<?php

session_start();

// базовая директория приложения
$baseDir = __DIR__ . '/';

// грузим автолоадер
include $baseDir . 'vendor/autoload.php';

// создаем объект с приложением
$Application = new \Lib\Application\Application($baseDir);
// сетим конфиг
$Application->setConfigDir($baseDir . 'config/prod/');
// запускаем приложение
$Application->run();
