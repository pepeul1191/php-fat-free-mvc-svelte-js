<?php

require 'vendor/autoload.php';

define('BASE_PATH', dirname(__FILE__));
define('VIEW_PATH', BASE_PATH . '/app/Views');

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$f3 = \Base::instance();

include_once BASE_PATH . '/app/Config/routes.php';

$f3->run();