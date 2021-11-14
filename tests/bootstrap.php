<?php

use Nip\Container\Container;

define('PROJECT_BASE_PATH', realpath(__DIR__ . '/..'));
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
$container->set('inflector', new \Nip\Inflector\Inflector());
Container::setInstance($container);
