<?php

/**
 * 1 - режим дебага/разработки
 * 0 - режим релиза
 */
define("DEBUG", 1);

/**
 * Эта константа ведет на корень приложения
 */
define("ROOT", dirname(__DIR__));

/**
 * Хранит путь к папке public
 */
define("WWW", ROOT . '/public');

/**
 * Хранит путь к папке app
 */
define("APP", ROOT . '/app');

/**
 * Хранит путь к ядру
 */
define("CORE", ROOT . '/vendor/wfm');

/**
 * Хранит путь к папке c функциями для дебага
 */
define("HELPERS", ROOT . '/vendor/wfm/helpers');

/**
 * Хранит путь к папке с кэшом
 */
define("CACHE", ROOT . '/tmp/cache');

/**
 * Хранит путь к папке с логами
 */
define("LOGS", ROOT . '/tmp/logs');

/**
 * Хранит путь к папке с конфигурационными файлами
 */
define("CONFIG", ROOT . '/config');

/**
 * Шаблон по умолчанию
 * шаблон можно потом переопределить
 */
define("LAYOUT", 'mynewframework');

/**
 * Хранит http путь к нашему сайту
 */
define("PATH", 'http://mynewframework');

/**
 * Хранит http путь к админке нашего сайта
 */
define("ADMIN", 'http://mynewframework/admin');

/**
 * Путь к картинке, если у товара картинки нет
 */
define("NO_IMAGE", 'uploads/no_image.jpg');


require_once ROOT . '/vendor/autoload.php';