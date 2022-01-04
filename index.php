<?php

require 'vendor/autoload.php';

// contants
define('BASE_PATH', dirname(__FILE__));
define('VIEW_PATH', BASE_PATH . '/app/Views');
// load .env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// app instance
$f3 = \Base::instance();
// app constants
$f3->mset(include_once BASE_PATH . '/app/Config/constants.php');
// routes
include_once BASE_PATH . '/app/Config/routes.php';
// run
$f3->run();