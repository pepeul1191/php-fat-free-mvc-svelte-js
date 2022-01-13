<?php

require 'vendor/autoload.php';

// constants
define('BASE_PATH', dirname(__FILE__));
define('VIEW_PATH', BASE_PATH . '/app/Views');
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');
// load .env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// app instance
$f3 = \Base::instance();
$f3->TIMEOUT=7200;// define session timeout here (in seconds)
ini_set('session.gc_maxlifetime',$f3->TIMEOUT);// see note (*) below
ini_set('session.cookie_lifetime',$f3->TIMEOUT);// optional (**)
// app constants
$f3->mset(include_once BASE_PATH . '/app/Config/constants.php');
// routes
include_once BASE_PATH . '/app/Config/routes.php';
// run
$f3->run();