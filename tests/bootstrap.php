<?php

use Nip\Container\Container;

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
$container->set('inflector', new \Nip\Inflector\Inflector());
Container::setInstance($container);
